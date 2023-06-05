<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STENOWORLD</title>
    <link rel="stylesheet" href="../Styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"></a>
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
                        <a class="nav-link" href="../pages/PageContact.php">Contact</a>
                    </li>
                    <?php
                    session_start();
                    if (isset($_SESSION['pseudo'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="./pages/espace-membre.php">Mon Compte</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="./pages/deconnexion.php">Déconnexion</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="../pages/connexion.php">Espace Membre</a></li>';
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

        // Récupérer les articles depuis la base de données
        $sql = "SELECT * FROM articles";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<article class="card">';
                echo '<div class="card-body">';
                echo '<h2 class="card-title">' . $row['titre'] . '</h2>';
                echo '<p class="card-text">' . $row['contenu'] . '</p>';

                if ($isAdmin) {
                    echo '<a href="modifier-article.php?id=' . $row['id'] . '" class="btn btn-primary">Modifier</a>';
                }

                echo '</div>';
                echo '</article>';
            }
        } else {
            echo '<p>Aucun article trouvé.</p>';
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
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/68a7839f62.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>