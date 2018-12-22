<?php 
	session_name('vote');
	session_start();
	$message = "";

	if (isset($_SESSION['erreur'])) 
	{
		$err1 = $_SESSION['error1'];
		$err2 = $_SESSION['error2'];
		$err3 = $_SESSION['error3'];
		$err4 = $_SESSION['error4'];
		$message .= "Authentification echoué <br>";
	}
	else
	{
		$err1 = null;
		$err2 = null;
		$err3 = null;
		$err4 = null;
		$message .= null;
	}
 ?>
 <style type="text/css">
 	em
 	{
 		color: red;
 	}
 </style>
<h1>Connectez vous pour voter</h1>
<em> <?= $message ?></em>
	 <?= $err4 ?>
<form method="post" action="connecter.php">
	<?= $err2 ?>
 	<label>Votre nom complet</label><br>
 	<input type="text" name="nom"><br>
 	<label>Votre mot de passe</label><br>
 	<input type="password" name="mdp"><br>
 	<?= $err1 ?>
 	<label>Selectionner votre cellule</label><br>
 	<select name="cellule">
 		<option value="1">CONFERENCE</option>
 		<option value="2">LECTURE</option>
 		<option value="3">SPORT ET LOISIR</option>
 		<option value="4">FILM</option>
 		<option value="5">VIE ET ANIMATION CHRETIENNE</option>
 		<option value="6">ACCUEIL</option>
 		<option value="7">ECOLOGIE</option>
 		<option value="8">RENDEZ-VOUS DES ELEVES</option>
 		<option value="9">SPECTACLE</option>
 		<option value="10">DEVELOPPEMENT</option>
 	</select><br>
 	<input type="submit" name="" value="Connexion">
 </form>