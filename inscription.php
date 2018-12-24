<?php
	session_name('fideleplk');
	session_start();
	if (isset($_SESSION['err'])) {
		$pseudo = $_SESSION['pseudo'];
		$email = $_SESSION['email'];
		$mdp = $_SESSION['mdp'];
		$date = $_SESSION['date'];
	}
	else{
		$_SESSION['pseudo'] = null;
		$_SESSION['email'] = null;
		$_SESSION['mdp'] = null;
		$_SESSION['date'] = null;
		$_SESSION['error3'] = null;
		$_SESSION['error1'] = null;
		$_SESSION['error2'] = null;
		$_SESSION['error4'] = null;

	}
?>
<form method="post" action="essaie.php" enctype="multipart/form-data">
	<input type="text" name="pseudo" placeholder="votre pseudo" value="<?= $_SESSION['pseudo']?>"><br>
	<em><?= $_SESSION['error1']; ?></em>
	<input type="email" name="email" placeholder="votre email" value="<?= $_SESSION['email']?>"><br>
	<em><?= $_SESSION['error3']; ?></em>
	<input type="password" name="mdp" placeholder="votre mot de passe" value="<?= $_SESSION['mdp']?>"><br>
	<em><?= $_SESSION['error2']; ?></em>
	<input type="password" name="mdpverif" placeholder="confirmer mot de passe" value="<?= $_SESSION['mdp']?>"><br>
	<em><?= $_SESSION['error2']; ?></em>
	<input type="text" name="date" placeholder="votre dat de naiss " value="<?= $_SESSION['date'] ?>"><i> Format JJ/MM/AAAA</i><br>
	<em><?= $_SESSION['error4']; ?></em>
	<label for="avatar"> Avatar :</label>
	<input type="file" name="avatar" id="avatar" /> (Taille max : 10 ko)<br /><br />
	<input type="submit" name="envoyer" value="envoyer"><br>
</form>