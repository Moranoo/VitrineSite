<?php
session_start();

if (isset($_SESSION['pseudo'])) {
    // L'utilisateur est déjà connecté
    if ($_SESSION['role'] === 'admin') {
        // Redirection vers la page admin pour l'administrateur
        header("Location: admin/admin.php");
    } else {
        // Redirection vers la page espace-membre pour les autres membres
        header("Location: espace-membre.php");
    }
    exit;
}

if (isset($_POST['valider'])) {
    if (!isset($_POST['pseudo'], $_POST['mdp'])) {
        echo "Un des champs n'est pas reconnu.";
    } else {
        $mysqli = new mysqli('localhost', 'root', '', 'steno');
        if ($mysqli->connect_errno) {
            echo "Erreur connexion BDD : " . $mysqli->connect_error;
        } else {
            $pseudo = $mysqli->real_escape_string($_POST['pseudo']);
            $mdp = $_POST['mdp'];

            // Vérifier si le pseudo existe dans la base de données
            $req = $mysqli->prepare("SELECT * FROM membres WHERE pseudo=?");
            $req->bind_param("s", $pseudo);
            $req->execute();
            $result = $req->get_result();
            if ($result->num_rows != 1) {
                echo "Pseudo ou mot de passe incorrect.";
            } else {
                $row = $result->fetch_assoc();
                if (password_verify($mdp, $row['mdp'])) {
                    if ($row['status'] === 'blocked') {
                        echo "Votre compte est bloqué. Veuillez contacter l'administrateur.";
                    } else {
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['role'] = $row['role'];
                        $req->close();
                        $mysqli->close();
                        if ($row['role'] === 'admin') {
                            // Redirection vers la page admin pour l'administrateur
                            header("Location: admin.php");
                        } else {
                            // Redirection vers la page espace-membre pour les autres membres
                            header("Location: espace-membre.php");
                        }
                        exit;
                    }
                } else {
                    echo "Pseudo ou mot de passe incorrect.";
                }
            }
            $req->close();
        }
        $mysqli->close();
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Espace membre</title>
    <link rel="stylesheet" href="../Styles/style.css">
    <link rel="stylesheet" href="../Styles/pages/boutton.css">
</head>

<body id="cover">
<div class="blur-background">

        <h1>Se connecter</h1>

    <?php
    if (!isset($traitementFini)) {
    ?>
    <div class="blur-background">
        <p>Remplissez le formulaire ci-dessous pour vous connecter :</p>
        <form method="post" action="connexion.php">
            <input type="text" name="pseudo" placeholder="Votre pseudo..." required>
            <input type="password" name="mdp" placeholder="Votre mot de passe..." required>
            <input type="submit" name="valider" value="Connexion!">
        </form>
        <br>
        <br>
        <a href="inscription.php">S'inscrire</a>
        <br>
        <a href="../index.php">Retour à l'accueil</a>
    </div>
    <?php
    }
    ?>
</body>

</html>