<?php
	session_name('fideleplk');
	session_start();

	require_once 'fonctions/classe.php';
	require_once 'fonctions/bdd.php';

	$user = new membre();

	$user->Actualisersession();
	
	if (isset($_SESSION['err'])) {
		$err1 = $_SESSION['error1'];
		$err2= $_SESSION['error2'];
		$err3 = $_SESSION['error3'];
	}
	else{
		$err1 = null;
		$err2 = null;
		$err3 = null;
	}
?>
<h1>Connectez-vous</h1>
<?= $err1?>
<form method="post" action="traitement.php" enctype="multipart/form-data">
	<input type="text" name="pseudo" placeholder="votre pseudo" ><br>
	<em><?= $err2; ?></em>
	<input type="password" name="mdp" placeholder="votre mot de passe" ><br>
	<em><?= $err3; ?></em>
	<label>Se souvenir de moi?</label> <input type="checkbox" name="cookie" value="souvenir"><br>
	<input type="submit" name="envoyer" value="envoyer"><br>
</form>