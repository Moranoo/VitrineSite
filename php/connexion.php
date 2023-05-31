<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Espace membre</title>
    <link rel="stylesheet" href="../Styles/pages/boutton.css">
</head>
<body>
    </head>
    <body>
      
    <h1>Se connecter</h1>    
    

    <?php
    if (isset($_SESSION['pseudo'])) {
        echo "Vous êtes déjà connecté. Vous pouvez accéder à l'espace membre en <a href='espace-membre.php'>cliquant ici</a>.";
    } else {
        if (isset($_POST['valider'])) {
            if (!isset($_POST['pseudo'], $_POST['mdp'])) {
                echo "Un des champs n'est pas reconnu.";
            } else {
                $mysqli = new mysqli('localhost', 'root', '', 'steno');
                if ($mysqli->connect_errno) {
                    echo "Erreur connexion BDD";
                } else {
                    $pseudo = $mysqli->real_escape_string($_POST['pseudo']);
                    $mdp = md5($_POST['mdp']);

                    // Vérifier si le pseudo et le mot de passe correspondent
                    $req = $mysqli->prepare("SELECT * FROM membres WHERE pseudo=? AND mdp=?");
                    $req->bind_param("ss", $pseudo, $mdp);
                    $req->execute();
                    $result = $req->get_result();
                    if ($result->num_rows != 1) {
                        echo "Pseudo ou mot de passe incorrect.";
                    } else {
                        $_SESSION['pseudo'] = $pseudo;
                        $req->close();
                        $mysqli->close();
                        header("Location: super-admin.php"); // Redirection vers la page Super Admin
                        exit;
                    }
                    $req->close();
                }
                $mysqli->close();
            }
        }

        if (!isset($traitementFini)) {
            ?>
            
            <p>Remplissez le formulaire ci-dessous pour vous connecter :</p>
            <form method="post" action="connexion.php">
                <input type="text" name="pseudo" placeholder="Votre pseudo..." required>
                <input type="password" name="mdp" placeholder="Votre mot de passe..." required>
                <input type="submit" name="valider" value="Connexion!">
            </form>
            <br>
            <br>
            <br>
            <a href="inscription.php">S'inscrire</a>
      
    </body>
    <a href="../index.html">Retour à l'accueil</a>
            <?php
        }
    }
    ?>
</body>
</html>
