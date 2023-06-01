<?php
if(isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    $to = '12mourad4@gmail.com';
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = 'From: ' . $_POST['name'] . ' <' . $_POST['email'] . '>';

    if(mail($to, $subject, $message, $headers)) {
        // Redirection avec message de réussite
        header('Location: PageContact.php?success=1');
        exit;
    } else {
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
