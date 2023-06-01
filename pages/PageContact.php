<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
    <a href="../index.php" class="d-flex justify-content-center mt-4">
        <img class="mb-4" src="../img/clavier.jpg" alt="logo de Sténotypie" width="82" height="82">
    </a>

    <!--Section: Contact v.2-->
    <section class="mb-4 container">
        <!--Section heading-->
        <h2 class="h1-responsive font-weight-bold text-center my-4">Contactez Nous</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">Vous avez des questions ? Contactez-nous</p>

        <div class="row">
            <!--Grid column-->
            <div class="col-md-9 mb-md-0 mb-5">
                <form id="contact-form" name="contact-form" action="envoi-mail.php" method="POST">
                    <!--Grid row-->
                    <div class="row">
                        <!--Grid column-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="form-control">
                                <label for="name">Votre nom</label>
                            </div>
                        </div>
                        <!--Grid column-->
                        <!--Grid column-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="email" name="email" class="form-control">
                                <label for="email">Votre email</label>
                            </div>
                        </div>
                        <!--Grid column-->
                    </div>
                    <!--Grid row-->
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" id="subject" name="subject" class="form-control">
                                <label for="subject">Objet de votre mail</label>
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->
                    <!--Grid row-->
                    <div class="row">
                        <!--Grid column-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea type="text" id="message" name="message" rows="2" class="form-control"></textarea>
                                <label for="message">Votre message</label>
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->
                    <div class="text-center text-md-left">
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                        <div class="status">
                            <?php
                            if(isset($_GET['success']) && $_GET['success'] == 1) {
                                echo '<div class="alert alert-success">Le message a été envoyé avec succès.</div>';
                            } elseif(isset($_GET['error']) && $_GET['error'] == 1) {
                                echo '<div class="alert alert-danger">Une erreur est survenue lors de l\'envoi du message.</div>';
                            } elseif(isset($_GET['error']) && $_GET['error'] == 2) {
                                echo '<div class="alert alert-warning">Veuillez remplir tous les champs du formulaire.</div>';
                            }
                            ?>
                        </div>
                        <a href="../index.php">Retour à l'accueil</a>
                    </div>
                </form>
                <div class="status"></div>
            </div>
            <!--Grid column-->
            <!--Grid column-->
            <div class="col-md-3 text-center">
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-map-marker-alt fa-2x"></i>
                        <p>Paris, FRANCE</p>
                    </li>
                    <li><i class="fas fa-phone mt-4 fa-2x"></i>
                        <p>+ 01 234 567 89</p>
                    </li>
                    <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                        <p>contact@Sténotypie.com</p>
                    </li>
                </ul>
            </div>
            <!--Grid column-->
        </div>
    </section>
    <!--Section: Contact v.2-->

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
