<?php


session_start();
unset($_SESSION['pseudo']);
header("Refresh: 5; url=../index.php");
// pour rediriger vers la page d'accueil du site après 5 secondes il faut mettre 
echo "Vous avez été correctement déconnecté du site.<br><br><i>Redirection en cours, vers la page d'accueil...</i>";

?>