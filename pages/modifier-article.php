<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STENOWORLD - Modifier l'article</title>
    <link rel="stylesheet" href="/SiteDPP/Styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="../index.php"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/article.php">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/SiteDPP/pages/PageContact.php">Contact</a>
                    </li>
                    <?php
                    session_start();
                    if (isset($_SESSION['pseudo'])) {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="/SiteDPP/pages/espace-membre.php">Mon Compte</a>
                              </li>';
                        echo '<li class="nav-item">
                                <a class="nav-link" href="/SiteDPP/pages/deconnexion.php">Déconnexion</a>
                              </li>';
                    } else {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="/SiteDPP/pages/connexion.php">Espace Membre</a>
                              </li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container">
    <?php
    $isAdmin = false;

    if (isset($_SESSION['pseudo']) && $_SESSION['role'] === 'admin') {
        $isAdmin = true;
    }

    // Établir une connexion à la base de données
    $servername = "localhost";  // Remplacez par l'adresse du serveur de la base de données
    $username = "root";  // Remplacez par votre nom d'utilisateur de la base de données
    $password = "";  // Remplacez par votre mot de passe de la base de données
    $dbname = "steno";  // Remplacez par le nom de votre base de données

    // Établir la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Vérifier si l'ID de l'article est passé dans la requête GET
    if (isset($_GET['id'])) {
        $articleId = $_GET['id'];

        // Vérifier si le formulaire a été soumis pour modifier l'article
        if (isset($_POST['modifier'])) {
            $newTitre = $_POST['titre'];
            $newContenu = mysqli_real_escape_string($conn, $_POST['contenu']);
        
            // Vérifier la longueur du contenu
            if (strlen($newContenu) > 500) {
                echo '<div class="alert alert-danger" role="alert">Le contenu de l\'article ne peut pas dépasser 220 caractères.</div>';
            } else {
                // Mettre à jour l'article dans la base de données
                $updateSql = "UPDATE articles SET titre = '$newTitre', contenu = '$newContenu' WHERE id = $articleId";
                if ($conn->query($updateSql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">Article modifié avec succès !</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Erreur lors de la modification de l\'article : ' . $conn->error . '</div>';
                }
            }
        }

        // Récupérer l'article depuis la base de données après la mise à jour
        $sql = "SELECT * FROM articles WHERE id = $articleId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<h2>Modifier l'article</h2>";

            echo '<form method="POST" action="modifier-article.php?id=' . $row['id'] . '">';
            echo '<div class="form-group">';
            echo '<label for="titre">Titre :</label>';
            echo '<input type="text" class="form-control" id="titre" name="titre" value="' . $row['titre'] . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="contenu">Contenu :</label>';
            echo '<textarea class="form-control" id="contenu" name="contenu" required>' . $row['contenu'] . '</textarea>';
            echo '</div>';

            echo '<button type="submit" class="btn btn-primary" name="modifier">Modifier</button>';
            echo '<a href="supprimer-article.php?id=' . $row['id'] . '" class="btn btn-danger">Supprimer</a>';
            echo '<a href="article.php?id=' . $row['id'] . '" class="btn btn-secondary">Annuler</a>';
            echo '<a href="article.php" class="btn btn-secondary">Retour</a>';
            echo '</form>';
        } else {
            echo '<p>Article non trouvé.</p>';
        }
    } else {
        echo '<p>Aucun ID d\'article fourni.</p>';
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</main>

<footer>
    <div class="social-icons">
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-snapchat-ghost"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
    </div>
</footer>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
<script src="https://kit.fontawesome.com/68a7839f62.js" crossorigin="anonymous"></script>
</body>
</html>