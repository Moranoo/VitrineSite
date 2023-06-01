<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Script espace membre</title>

<body>
<style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding-top: 50px;
            }

            h1 {
                color: #333;
            }

            a {
                display: inline-block;
                margin: 10px auto;
                padding: 10px 20px;
                color: #fff;
                background-color: #007BFF;
                text-decoration: none;
                border-radius: 5px;
            }

            a:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
        <h1>Bienvenue!</h1>
        <p>Choisissez une option:</p>
        <a href="inscription.php">S'inscrire</a>
        <br>
        <a href="connexion.php">Se connecter</a>
        <br>
    <a href="/SiteDPP/index.php">Retour à l'accueil</a>
    <br>