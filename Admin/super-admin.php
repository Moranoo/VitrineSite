<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que super administrateur
if (!isset($_SESSION['pseudo']) || $_SESSION['pseudo'] !== 'admin') {
    header("Location: connexion.php"); // Rediriger vers la page de connexion si non connecté en tant que super admin
    exit;
}

// Traitement des actions pour la gestion des comptes des membres
if (isset($_POST['action'], $_POST['member_id'])) {
    $action = $_POST['action'];
    $member_id = $_POST['member_id'];

    // Exécuter les actions souhaitées en fonction de la valeur de $action
    if ($action === 'delete') {
        // Supprimer le compte du membre avec l'ID $member_id dans la base de données
        // Effectuer la suppression en utilisant les requêtes SQL appropriées
        // ...
        echo "Le compte du membre avec l'ID $member_id a été supprimé avec succès.";
    } elseif ($action === 'block') {
        // Bloquer le compte du membre avec l'ID $member_id dans la base de données
        // Effectuer la mise à jour en utilisant les requêtes SQL appropriées
        // ...
        echo "Le compte du membre avec l'ID $member_id a été bloqué.";
    } elseif ($action === 'unblock') {
        // Débloquer le compte du membre avec l'ID $member_id dans la base de données
        // Effectuer la mise à jour en utilisant les requêtes SQL appropriées
        // ...
        echo "Le compte du membre avec l'ID $member_id a été débloqué.";
    }
}

// Afficher les informations du super administrateur
echo "Bienvenue, Super Admin ".$_SESSION['pseudo']." !";
echo "<br>";
echo "Vous pouvez gérer les comptes des membres ci-dessous :";

// Afficher la liste des membres avec les options de gestion
$mysqli = new mysqli('localhost', 'root', '', 'steno');
if ($mysqli->connect_errno) {
    echo "Erreur connexion BDD";
} else {
    $req = $mysqli->query("SELECT * FROM membres");
    if ($req->num_rows > 0) {
        echo "<ul>";
        while ($row = $req->fetch_assoc()) {
            $member_id = $row['id'];
            $member_pseudo = $row['pseudo'];
            $member_status = $row['status'];
            $member_status_label = ($member_status === 'active') ? 'Actif' : 'Bloqué';

            echo "<li>";
            echo "ID : $member_id | Pseudo : $member_pseudo | Statut : $member_status_label";
            echo "<form method='post' action='super-admin.php'>";
            echo "<input type='hidden' name='member_id' value='$member_id'>";
            echo "<select name='action'>";
            echo "<option value='delete'>Supprimer</option>";
            echo "<option value='block'>Bloquer</option>";
            echo "<option value='unblock'>Débloquer</option>";
            echo "</select>";
            echo "<input type='submit' value='Appliquer'>";
            echo "</form>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun membre trouvé.";
    }
    $req->close();
    $mysqli->close();
}
?>
