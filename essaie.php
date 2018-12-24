<?php
	session_name("fideleplk");
	session_start();
	require_once "fonctions/bdd.php";
	require_once "fonctions/classe.php";
	$nom = $_POST['pseudo'];
	$mdp = $_POST['mdp'];
	$email = $_POST['email'];
	$mdpverif = $_POST['mdpverif'];
	$date = $_POST["date"];
	$avatar = $_FILES['avatar']['name'];
	$avatar = null;
	$_SESSION['error1'] = null;
	$_SESSION['error2'] = null;
	$_SESSION['error3'] = null;
	$_SESSION['error4'] = null;
	$_SESSION['pseudo'] = null;
	$_SESSION['mdp'] = null;
	$_SESSION['email'] = null;
	$i = 0;
	$control = new membre();
	// verification du pseudo
	if ($control->checkpseudo($nom) == "vide"){$_SESSION['error1'] = "vous n'avez pas entre de pseudo<br>"; $i++;} 
	elseif ($control->checkpseudo($nom) == "court"){$_SESSION['error1'] = "votre pseudo ne doit pas avoir moins de 4 caracteres<br>"; $i++;} 
	elseif ($control->checkpseudo($nom) == "long"){$_SESSION['error1'] = "votre pseudo ne doit pas avoir plus de 64 caracteres<br>"; $i++;}
	else $_SESSION['pseudo'] = $control->pseudo;

	//verification du mpd
	if ($control->checkmdp($mdp) == "vide") {$_SESSION['error2'] = "Vous n'avez pas entré de mot de passe<br>"; $i++;}
	elseif ($control->checkmdp($mdp) == "court"){ $_SESSION['error2'] = "Votre mot de passe est trop court choisissez en un moyen<br>"; $i++;}
	elseif ($control->checkmdp($mdp) == "long"){$_SESSION['error2'] = "Votre mot de passe est trop long choisissez en un moyen<br>"; $i++;}
	elseif ($control->checkmdp($mdp) == "nofigure"){$_SESSION['error2'] = "Votre mot de passe doit contenir au moins un caractère psécial<br>"; $i++;} 
	elseif ($control->checkmdp($mdp) == "noupcap"){$_SESSION['error2'] = "Votre mot de passe doit contenir au moins une lettre majuscule<br>"; $i++;} 
	elseif ($control->confirmdp($mdpverif) == "Nconf"){$_SESSION['error2'] = "les deux mots de passe ne correspondent pas <br>"; $i++;}
	else $_SESSION['mdp'] = $control->mdp;
	//verification de l'email

	if ($control->checkmail($email) == "vide" ){$_SESSION['error3'] = "Vous n'avez pas entré de mail<br>"; $i++;} 
	elseif($control->checkmail($email) == "isnt"){$_SESSION['error3'] = "Le mail que vous avez entré n'a pas un format valide<br>"; $i++;} 
	elseif($control->checkmail($email) == "exists"){$_SESSION['error3'] = "Le mail que vous voulez utiliser existe cherchez en un autre<br>";$i++;} 
	else $_SESSION['email'] = $control->email;

	// verification de la date de naissance

	if($control->verifdate($date) == 'vide'){$_SESSION['error4']  = "Vous n'avez pas spécifié votre date de naissance<br>"; $i++;}
	elseif ($control->verifdate($date) == "badate"){$_SESSION['error4'] = "Vous avez entré une date avec un format incorrect"; $i++;}
	else $_SESSION['date'] = $control->date;

	if($control->avatar($avatar) == 'long'){$_SESSION['error5'] = "le fichier depasse la limite autorisée sur le serveur<br>"; $i++;}
	elseif($control->avatar($avatar) == 'grand'){$_SESSION['error5'] = "Le fichier dépasse la limite autorisée dans le formulaire HTML !<br>"; $i++;}
	elseif($control->avatar($avatar) == 'echec'){$_SESSION['error5'] = "L'envoi du fichier a été interrompu pendant le transfert !"; $i++;}
	elseif($control->avatar($avatar) == 'vide'){$_SESSION['error5'] = "Le fichier que vous avez envoyé a une taille nulle !"; $i++;}
	else $_SESSION['avatar'] = $control->avatar;

	if ($i>0) {
		$_SESSION['err'] = $i;
		header("location: index.php");
	}
	else
	{
		$control->inserer();
		header('location: page.php');

	}

?>