<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Script espace membre</title>
    <link rel="stylesheet" href="../Styles/pages/boutton.css">
</head>
<body>
    <h1>S'inscrire</h1>

    <?php
    if (isset($_POST['valider'])) {
        if (!isset($_POST['pseudo'], $_POST['mdp'], $_POST['mail'], $_POST['nom'], $_POST['prenom'])) {
            echo "Un des champs n'est pas reconnu.";
        } else {
            $mysqli = new mysqli('localhost', 'root', '', 'steno');
            if ($mysqli->connect_errno) {
                echo "Erreur connexion BDD : " . $mysqli->connect_error;
            } else {
                $pseudo = $mysqli->real_escape_string($_POST['pseudo']);
                $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                $mail = $mysqli->real_escape_string($_POST['mail']);
                $nom = $mysqli->real_escape_string($_POST['nom']);
                $prenom = $mysqli->real_escape_string($_POST['prenom']);

                // Vérifier si le pseudo est déjà utilisé
                $result = $mysqli->query("SELECT * FROM membres WHERE pseudo='$pseudo'");
                if ($result->num_rows > 0) {
                    echo "Ce pseudo est déjà utilisé par un autre membre, veuillez en choisir un autre svp.";
                } else {
                    // Insérer les données dans la base de données
                    $insert = $mysqli->query("INSERT INTO membres (pseudo, mdp, mail, nom, prenom) VALUES ('$pseudo', '$mdp', '$mail', '$nom', '$prenom')");
                    if ($insert) {
                        echo "Inscription réussie!";
                        // Forcer la mise à jour de la session
                        session_write_close();

                        echo "Inscrit avec succès !  Vous pouvez vous connecter: <a href='connexion.php'>Cliquez ici</a>.";
                        $traitementFini = true;
                    } else {
                        echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
                    }
                }
                $mysqli->close();
            }
        }
    }

    if (!isset($traitementFini)) {
        ?>
        <br>
        <p>Remplissez le formulaire ci-dessous pour vous inscrire:</p>
        <form method="post" action="inscription.php">
            <input type="text" name="pseudo" placeholder="Votre pseudo..." required>
            <input type="password" name="mdp" placeholder="Votre mot de passe..." required>
            <input type="email" name="mail" placeholder="Votre mail..." required>
            <input type="text" name="nom" placeholder="Votre nom..." required>
            <input type="text" name="prenom" placeholder="Votre prénom..." required>
            <input type="submit" name="valider" value="Cliquez ici pour envoyer le formulaire">
        </form>
        <br>
        <br>
        <a href="connexion.php">Se connecter</a>

        <a href="../index.php">Retour à l'accueil</a>
        <br>
        <?php
    }
    ?>
</body>
</html>
