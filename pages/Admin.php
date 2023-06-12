<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['pseudo']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: connexion.php");
    exit;
}

// Traitement des actions pour la gestion des membres
if (isset($_POST['action'], $_POST['member_id'])) {
    $action = $_POST['action'];
    $member_id = $_POST['member_id'];

    // Exécuter les actions souhaitées en fonction de la valeur de $action
    $message = '';
    $mysqli = new mysqli('localhost', 'root', '', 'steno');
    if ($mysqli->connect_errno) {
        $message = "Erreur connexion BDD";
    } else {
        if ($action === 'delete') {
            // Supprimer le membre avec l'ID $member_id de la base de données
            $stmt = $mysqli->prepare("DELETE FROM membres WHERE id = ?");
            $stmt->bind_param("i", $member_id);
            if ($stmt->execute()) {
                $message = "Le membre avec l'ID $member_id a été supprimé avec succès.";
            } else {
                $message = "Une erreur est survenue lors de la suppression du membre.";
            }
            $stmt->close();
        } elseif ($action === 'block') {
            // Bloquer le membre avec l'ID $member_id dans la base de données
            $stmt = $mysqli->prepare("UPDATE membres SET status = 'blocked' WHERE id = ?");
            $stmt->bind_param("i", $member_id);
            if ($stmt->execute()) {
                $message = "Le membre avec l'ID $member_id a été bloqué.";
            } else {
                $message = "Une erreur est survenue lors du blocage du membre.";
            }
            $stmt->close();
        } elseif ($action === 'unblock') {
            // Débloquer le membre avec l'ID $member_id dans la base de données
            $stmt = $mysqli->prepare("UPDATE membres SET status = 'active' WHERE id = ?");
            $stmt->bind_param("i", $member_id);
            if ($stmt->execute()) {
                $message = "Le membre avec l'ID $member_id a été débloqué.";
            } else {
                $message = "Une erreur est survenue lors du déblocage du membre.";
            }
            $stmt->close();
        } elseif ($action === 'admin') {
            // Rendre le membre avec l'ID $member_id administrateur
            $stmt = $mysqli->prepare("UPDATE membres SET role = 'admin' WHERE id = ?");
            $stmt->bind_param("i", $member_id);
            if ($stmt->execute()) {
                $message = "Le membre avec l'ID $member_id est maintenant administrateur.";
            } else {
                $message = "Une erreur est survenue lors de la modification du statut du membre.";
            }
            $stmt->close();
        } elseif ($action === 'user') {
            // Rendre le membre avec l'ID $member_id utilisateur normal
            $stmt = $mysqli->prepare("UPDATE membres SET role = 'user' WHERE id = ?");
            $stmt->bind_param("i", $member_id);
            if ($stmt->execute()) {
                $message = "Le membre avec l'ID $member_id est maintenant un utilisateur normal.";
            } else {
                $message = "Une erreur est survenue lors de la modification du statut du membre.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();

    if (!empty($message)) {
        $_SESSION['action_message'] = $message;
        header("Location: admin.php"); // Redirection pour éviter la soumission multiple des formulaires
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page d'administration</title>
    <link rel="stylesheet" href="/SiteDPP/Styles/style.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <h1 class="text-center">Page d'administration</h1>

    <?php
    // Afficher le message d'action si présent
    if (isset($_SESSION['action_message'])) {
        echo '<div class="alert alert-info text-center">' . $_SESSION['action_message'] . '</div>';
        unset($_SESSION['action_message']);
    }
    ?>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Statut</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysqli = new mysqli('localhost', 'root', '', 'steno');
                    if ($mysqli->connect_errno) {
                        echo "Erreur connexion BDD";
                    } else {
                        $req = $mysqli->query("SELECT * FROM membres");
                        if ($req->num_rows > 0) {
                            while ($row = $req->fetch_assoc()) {
                                $member_id = $row['id'];
                                $member_pseudo = $row['pseudo'];
                                $member_status = isset($row['status']) ? $row['status'] : 'active';
                                $member_role = isset($row['role']) ? $row['role'] : 'user';
                                $member_status_label = ($member_status === 'active') ? 'Actif' : 'Bloqué';
                                $member_role_label = ($member_role === 'admin') ? 'Admin' : 'Utilisateur';
                    ?>
                                <tr>
                                    <td><?php echo $member_id; ?></td>
                                    <td><?php echo $member_pseudo; ?></td>
                                    <td><?php echo $member_status_label; ?></td>
                                    <td><?php echo $member_role_label; ?></td>
                                    <td>
                                        <form method="post" action="Admin.php">
                                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                                            <select name="action" class="form-control">
                                                <option value="block">Bloquer</option>
                                                <option value="unblock">Débloquer</option>
                                                <option value="admin">Rendre admin</option>
                                                <option value="user">Rendre utilisateur</option>
                                                <option value="delete">Supprimer</option>
                                            </select>
                                            <input type="submit" value="Appliquer" class="btn btn-primary mt-2">
                                        </form>
                                    </td>
                                </tr>
                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun membre trouvé.</td></tr>";
                        }
                        $req->close();
                        $mysqli->close();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-secondary">Accueil</a>
    </div>
    <footer>
        <div class="footer-links">
        <a href="../pages/conditions-generales-utilisation.php">Conditions générales d'utilisation</a> | <a href="../pages/politique-confidentialite.php">Politique de confidentialité</a>
            <p class="btn-primary">© 2023 STENOWORLD</p>

        </div>
    </footer>
</body>

</html>