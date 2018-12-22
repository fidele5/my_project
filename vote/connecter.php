<?php
	session_name('vote');
	session_start();

	require_once 'vote.php';

	

	$nom = $_POST['nom'];
	$mdp = $_POST['mdp'];
	$cellule  =$_POST['cellule'];
	$_SESSION['error1'] = null;
	$_SESSION['error2'] = null;
	$_SESSION['error3'] = null;
	$_SESSION['error4'] = null;
	$i = 0;

	$electeur = new Election();

	if (empty($nom) && empty($mdp) && empty($cellule)) {
		$_SESSION['error4'] = "<em>Vous devez compléter tous les champs sans exception aucune</em><br>";
		$i++;
	}
	elseif ($electeur->connecter($nom, $mdp, $cellule) == 'wrong') {
		$_SESSION['error1'] = "<em>Vous avez entré un mot de passe incorrect</em><br>";
		$i++;
	}
	elseif ($electeur->connecter($nom, $mdp, $cellule) == 'voted') {
		$_SESSION['error2'] = "<em>Vous avez deja voté! vous n'etes pas permis d'acceder avant la publication</em><br>";
		$i++;
	}
	elseif ($electeur->connecter($nom, $mdp, $cellule) == 'none') {
		$_SESSION['error3'] = "<em>Vous n'appartenez pas a cette cellule veuillez selectionner la votre</em><br>";
		$i++;
	}
	else{
		header('location: voter.php');
	}

	if ($i>0) {
		$_SESSION['erreur'] = $i;
		header('location: connexion.php');
	}
	else
		header('location: voter.php');

	
?>