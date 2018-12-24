<?php
	session_name('fideleplk');
	session_start();

	require_once 'fonctions/classe.php';
	require_once 'fonctions/bdd.php';

	$pseudo = $_POST['pseudo'];
	$mdp = $_POST['mdp'];
	$cookies = $_POST['cookie'];

	$_SESSION['error2'] = null;
	$_SESSION['error3'] = null;
	$_SESSION['error1'] = null;
	$_SESSION['err'] = null;
	$i = 0;

	$user = new membre();

	if (empty($pseudo)) {
		$_SESSION['error2'] = "<em>Vous devez renseigner un pseudo</em><br>";
		$i++;
	}
	elseif (empty($mdp)) {
		$_SESSION['error3'] = "<em>Vous devez renseigner un mot de passe</em><br>";
		$i++;
	}
	elseif ($user->connexion($pseudo, $mdp, $cookies) == "incorrect") {
		$_SESSION['error1'] = "<em>Votre pseudo ou mot de passe est incorrect</em><br>";
		$i++;
	}
	else
		header('location: page.php');

	if ($i>0) {
		$_SESSION['err'] = $i;
		header('location: index.php');
	}
?>