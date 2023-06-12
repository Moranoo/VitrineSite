<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Vérifiez si les données du formulaire sont présentes
if(isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    // Définissez l'adresse e-mail de destination
    $to = 'myspeciality@outlook.com';
    
    // Récupérez les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Inclure les fichiers de PHPMailer
    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';
    

    // Créez une instance de PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Configurez le mode d'envoi
        $mail->isSMTP();
        
        // Configurez le serveur SMTP
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'votre-adresse-email@outlook.com';
        $mail->Password = 'votre-mot-de-passe';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        // Configurez l'expéditeur et le destinataire
        $mail->setFrom($email, $name);
        $mail->addAddress($to);
        
        // Définissez le sujet et le corps du message
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Envoyez le courrier électronique
        $mail->send();

        // Redirection avec message de réussite
        header('Location: PageContact.php?success=1');
        exit;
    } catch (Exception $e) {
        // Redirection avec message d'erreur
        header('Location: PageContact.php?error=1');
        exit;
    }
} else {
    // Redirection avec message d'erreur (champs non remplis)
    header('Location: PageContact.php?error=2');
    exit;
}
?>
