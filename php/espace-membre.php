<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Refresh: 5; url=connexion.php");
    echo "Vous devez vous connecter pour accéder à l'espace membre.<br><br><i>Redirection en cours, vers la page de connexion...</i>";
    exit(0);
}
$Pseudo = $_SESSION['pseudo'];

$mysqli = new mysqli('localhost', 'root', '', 'steno');
if ($mysqli->connect_error) {
    echo "Erreur connexion BDD";
    exit(0);
}

$req = $mysqli->prepare("SELECT * FROM membres WHERE pseudo=? AND mdp=?");
$req->bind_param("ss", $Pseudo, $Mdp);
$req->execute();

if ($req->get_result()->num_rows != 1) {
    echo "Mot de passe actuel incorrect.";
} else {
    $NouveauMdp = password_hash($_POST['nouveau_mdp'], PASSWORD_DEFAULT);
    $req = $mysqli->prepare("UPDATE membres SET mdp=? WHERE pseudo=?");
    $req->bind_param("ss", $NouveauMdp, $Pseudo);
    if ($req->execute()) {
        echo "Mot de passe modifié avec succès!";
        $TraitementFini = true;
    } else {
        echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
    }
}
?><!DOCTYPE HTML>
<html>
	<head>
		<title>Script espace membre</title>
	</head>
	<body>
	<a href="index.html"><img class="mb-4" src="img/logo.jpg" alt="logo de Sténotypie" style="width: 82px; height: 82px; margin-left: 30%;"></a>

		<h1>Espace membre</h1>
		Pour modifier vos informations, <a href="espace-membre.php?modifier">cliquez ici</a>
		<br>
		Pour supprimer votre compte, <a href="espace-membre.php?supprimer">cliquez ici</a>
		<br>
		Pour vous déconnecter, <a href="deconnexion.php">cliquez ici</a>
		<hr/>
		<?php
		if(isset($_GET['supprimer'])){
			if($_GET['supprimer']!="ok"){
				echo "<p>Êtes-vous sûr de vouloir supprimer votre compte définitivement?</p>
				<br>
				<a href='espace-membre.php?supprimer=ok' style='color:red'>OUI</a> - <a href='espace-membre.php' style='color:green'>NON</a>";
			} else {
				if(mysqli_query($mysqli,"DELETE FROM membres WHERE pseudo='$Pseudo'")){
					echo "Votre compte vient d'être supprimé définitivement.";
					unset($_SESSION['pseudo']);
				} else {
					echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
					//echo "<br>Erreur retournée: ".mysqli_error($mysqli);
				}
			}
		}
		if(isset($_GET['modifier'])){
			?>
			<h1>Modification du compte</h1>
			Choisissez une option: 
			<p>
				<a href="espace-membre.php?modifier=mail">Modifier l'adresse mail</a>
				<br>
				<a href="espace-membre.php?modifier=mdp">Modifier le mot de passe</a>
			</p>
			<hr/>
			<?php
			if($_GET['modifier']=="mail"){
				echo "<p>Renseignez le formulaire ci-dessous pour modifier vos informations:</p>";
				if(isset($_POST['valider'])){
					if(!isset($_POST['mail'])){
						echo "Le champ mail n'est pas reconnu.";
					} else {
						if(!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,30}$#i",$_POST['mail'])){
							echo "L'adresse mail est incorrecte.";
						} else {
							if(mysqli_query($mysqli,"UPDATE membres SET mail='".htmlentities($_POST['mail'],ENT_QUOTES,"UTF-8")."' WHERE pseudo='$Pseudo'")){
								echo "Adresse mail {$_POST['mail']} modifiée avec succès!";
								$TraitementFini=true;
							} else {
								echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
							}
						}
					}
				}
				if(!isset($TraitementFini)){
					?>
					<br>
					<form method="post" action="espace-membre.php?modifier=mail">
						<input type="email" name="mail" value="<?php echo $info['mail']; ?>" required><!-- required permet d'empêcher l'envoi du formulaire si le champ est vide -->
						<input type="submit" name="valider" value="Valider la modification">
					</form>
					<?php
				}
			} elseif($_GET['modifier']=="mdp"){
				echo "<p>Renseignez le formulaire ci-dessous pour modifier vos informations:</p>";
				if(isset($_POST['valider'])){
					if(!isset($_POST['nouveau_mdp'],$_POST['confirmer_mdp'],$_POST['mdp'])){
						echo "Un des champs n'est pas reconnu.";
					} else {
						if($_POST['nouveau_mdp']!=$_POST['confirmer_mdp']){
							echo "Les mots de passe ne correspondent pas.";
						} else {
							$Mdp=md5($_POST['mdp']);
							$NouveauMdp=md5($_POST['nouveau_mdp']);
							$req=mysqli_query($mysqli,"SELECT * FROM membres WHERE pseudo='$Pseudo' AND mdp='$Mdp'");
							if(mysqli_num_rows($req)!=1){
								echo "Mot de passe actuel incorrect.";
							} else {
								if(mysqli_query($mysqli,"UPDATE membres SET mdp='$NouveauMdp' WHERE pseudo='$Pseudo'")){
									echo "Mot de passe modifié avec succès!";
									$TraitementFini=true;
								} else {
									echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
								}
							}
						}
					}
				}
				if(!isset($TraitementFini)){
					?>
					<br>
					<form method="post" action="espace-membre.php?modifier=mdp">
						<input type="password" name="nouveau_mdp" placeholder="Nouveau mot de passe..." required><!-- required permet d'empêcher l'envoi du formulaire si le champ est vide -->
						<input type="password" name="confirmer_mdp" placeholder="Confirmer nouveau passe..." required>
						<input type="password" name="mdp" placeholder="Votre mot de passe actuel..." required>
						<input type="submit" name="valider" value="Valider la modification">
					</form>
					<?php
				}
			}
		}
		?>
	</body>
</html>