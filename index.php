<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STENOWORLD</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body id="cover">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <img class="mb-4" src="./img/clavier.jpg" alt="logo de Sténotypie" width="82" height="82" style="border-radius: 50%;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">    
                    <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Accueil</a>

                    </li>                
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/article.php">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/PageContact.php">Contact</a>
                    </li>
                    <?php
                    session_start();
                    if (isset($_SESSION['pseudo'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="./pages/espace-membre.php">Mon Compte</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="./pages/deconnexion.php">Déconnexion</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="./pages/connexion.php">Espace Membre</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="random-quote">
                <div class="blur-background" id="random-quote">
                    <h1 >Citation aléatoire</h1>
                    <p id="quote-content"></p>
                </div>
                </div>

                <article class="card mb-3">
                    <div class="card-body">
                        <h2 class="card-title">Article 1</h2>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt diam ut tortor commodo, vel rutrum enim rhoncus.</p>
                        <a href="./pages/article.php" class="btn btn-primary">Plus d'infos</a>
                    </div>
                </article>
            </div>

            <div class="col-md-6">
                <article class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Article 2</h2>
                        <p class="card-text">Sed aliquam lacus ut sem commodo bibendum. Maecenas mollis, ligula ac tincidunt bibendum, felis mauris interdum lacus.</p>
                        <a href="./pages/article.php" class="btn btn-primary">Plus d'infos</a>
                    </div>
                </article>
            </div>

            <div class="col-md-6">
                <article class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Article 3</h2>
                        <p class="card-text">Vestibulum ultrices est nec felis posuere, sed maximus leo auctor. Sed id luctus dui, non aliquet felis.</p>
                        <a href="./pages/article.php" class="btn btn-primary">Plus d'infos</a>
                    </div>
                </article>
            </div>

            <div class="col-md-6">
                <article class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Article 4</h2>
                        <p class="card-text">Phasellus vitae libero a tortor semper dictum sed vitae diam. Curabitur vehicula ligula a diam pellentesque feugiat.</p>
                        <a href="./pages/article.php" class="btn btn-primary">Plus d'infos</a>
                    </div>
                </article>
            </div>

            <div class="col-md-6">
                <article class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Article 5</h2>
                        <p class="card-text">Donec varius metus et mauris viverra, ut aliquam lacus dignissim. Sed at nisi a neque suscipit commodo vitae vitae est.</p>
                        <a href="./pages/article.php" class="btn btn-primary">Plus d'infos</a>
                    </div>
                </article>
            </div>
        </div>
    </main>

    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-snapchat-ghost"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>
    </footer>

    <script src="random.js"></script>
    <script src="https://kit.fontawesome.com/68a7839f62.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>