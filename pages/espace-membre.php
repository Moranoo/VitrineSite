<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Refresh: 5; url=connexion.php");
    echo "Vous devez vous connecter pour accéder à l'espace membre.<br><br><i>Redirection en cours, vers la page de connexion...</i>";
    exit(0);
}
$Pseudo = $_SESSION['pseudo'];

$mysqli = new mysqli('localhost', 'root', '', 'steno');
if ($mysqli->connect_error) {
    echo "Erreur connexion BDD";
    exit(0);
}

$req = $mysqli->prepare("SELECT * FROM membres WHERE pseudo=?");
$req->bind_param("s", $Pseudo);
$req->execute();
$result = $req->get_result();
if ($result->num_rows != 1) {
    echo "Erreur: Utilisateur non trouvé.";
    exit(0);
}
$row = $result->fetch_assoc();
$Role = $row['role'];
$Mdp = $row['mdp'];

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Espace membre</title>
    <link rel="stylesheet" href="/SiteDPP/Styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .logo-img {
            width: 82px;
            height: 82px;
            margin-left: 30%;
        }
    </style>
</head>

<body>
    <a href="../index.php"><img class="mb-4 logo-img" src="../img/clavier.jpg" alt="logo de Sténotypie"></a>
    <div class="container">
        <h1>Votre compte </h1>
        <p>Pour modifier vos informations, <a href="espace-membre.php?modifier">cliquez ici</a></p>
        <p>Pour supprimer votre compte, <a href="espace-membre.php?supprimer">cliquez ici</a></p>
        <p>Pour vous déconnecter, <a href="deconnexion.php">cliquez ici</a></p>
        <hr />
        <?php
        if ($Role == 'admin') {
            echo '<p>Vous êtes un administrateur. Accédez à la <a href="../pages/Admin.php">page Super Admin</a>.</p>';
        }

        if (isset($_GET['supprimer'])) {
            if ($_GET['supprimer'] != "ok") {
                echo '<p>Êtes-vous sûr de vouloir supprimer votre compte définitivement?</p>';
                echo '<p><a href="espace-membre.php?supprimer=ok" style="color:red">OUI</a> - <a href="espace-membre.php" style="color:green">NON</a></p>';
            } else {
                if (mysqli_query($mysqli, "DELETE FROM membres WHERE pseudo='$Pseudo'")) {
                    echo 'Votre compte vient d\'être supprimé définitivement.';
                    unset($_SESSION['pseudo']);
                } else {
                    echo 'Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.';
                    //echo "<br>Erreur retournée: ".mysqli_error($mysqli);
                }
            }
        }

        if (isset($_GET['modifier'])) {
            echo '<h1>Modification du compte</h1>';
            echo '<p>Choisissez une option:</p>';
            echo '<p><a href="espace-membre.php?modifier=mail">Modifier l\'adresse mail</a></p>';
            echo '<p><a href="espace-membre.php?modifier=mdp">Modifier le mot de passe</a></p>';
            echo '<hr/>';

            if ($_GET['modifier'] == "mail") {
                echo '<p>Renseignez le formulaire ci-dessous pour modifier vos informations:</p>';
                if (isset($_POST['valider'])) {
                    if (!isset($_POST['mail'])) {
                        echo 'Le champ mail n\'est pas reconnu.';
                    } else {
                        if (!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,30}$#i", $_POST['mail'])) {
                            echo 'L\'adresse mail est incorrecte.';
                        } else {
                            if (mysqli_query($mysqli, "UPDATE membres SET mail='" . htmlentities($_POST['mail'], ENT_QUOTES, "UTF-8") . "' WHERE pseudo='$Pseudo'")) {
                                echo 'Adresse mail ' . $_POST['mail'] . ' modifiée avec succès!';
                                $TraitementFini = true;
                            } else {
                                echo 'Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.';
                            }
                        }
                    }
                }

                if (!isset($TraitementFini)) {
                    echo '<form method="post" action="espace-membre.php?modifier=mail">';
                    echo '<input type="email" name="mail" value="' . (isset($info['mail']) ? $info['mail'] : '') . '" required>';
                    echo '<input type="submit" name="valider" value="Valider la modification">';
                    echo '</form>';
                }
            } elseif ($_GET['modifier'] == "mdp") {
                echo '<p>Renseignez le formulaire ci-dessous pour modifier vos informations:</p>';
                if (isset($_POST['valider'])) {
                    if (!isset($_POST['nouveau_mdp'], $_POST['confirmer_mdp'], $_POST['mdp'])) {
                        echo 'Un des champs n\'est pas reconnu.';
                    } else {
                        if ($_POST['nouveau_mdp'] != $_POST['confirmer_mdp']) {
                            echo 'Les mots de passe ne correspondent pas.';
                        } else {
                            $Mdp = md5($_POST['mdp']);
                            $NouveauMdp = md5($_POST['nouveau_mdp']);
                            $req = mysqli_query($mysqli, "SELECT * FROM membres WHERE pseudo='$Pseudo' AND mdp='$Mdp'");
                            if (mysqli_num_rows($req) != 1) {
                                echo 'Mot de passe actuel incorrect.';
                            } else {
                                if (mysqli_query($mysqli, "UPDATE membres SET mdp='$NouveauMdp' WHERE pseudo='$Pseudo'")) {
                                    echo 'Mot de passe modifié avec succès!';
                                    $TraitementFini = true;
                                } else {
                                    echo 'Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.';
                                }
                            }
                        }
                    }
                }

                if (!isset($TraitementFini)) {
                    echo '<form method="post" action="espace-membre.php?modifier=mdp">';
                    echo '<input type="password" name="nouveau_mdp" placeholder="Nouveau mot de passe..." required>';
                    echo '<input type="password" name="confirmer_mdp" placeholder="Confirmer nouveau passe..." required>';
                    echo '<input type="password" name="mdp" placeholder="Votre mot de passe actuel..." required>';
                    echo '<input type="submit" name="valider" value="Valider la modification">';
                    echo '</form>';
                }
            }
        }
        ?>
    </div>
    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-snapchat-ghost"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>
        <div class="footer-links">
        <a href="../pages/conditions-generales-utilisation.php">Conditions générales d'utilisation</a> | <a href="../pages/politique-confidentialite.php">Politique de confidentialité</a>
            <p class="btn-primary">© 2023 STENOWORLD</p>

        </div>
    </footer>
</body>

</html>