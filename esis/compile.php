<?php
	session_name('election');
	session_start();
    require_once('election.php');

    $elect  = new elections();

    $mat  = htmlspecialchars($_POST['mat']);
    $mdp  = htmlspecialchars($_POST['mdp']);
    $prom = htmlspecialchars($_POST['prom']);
    $i    = 0;
    $_SESSION['erreur1']   = null;
    $_SESSION['erreur2']   = null;
    $_SESSION['erreur3']   = null;
    $_SESSION['erreur4']   = null;
    $_SESSION['prom']      = null;
    $_SESSION['matricule'] = null;
    $_SESSION['pwd']       = null;

    // verification du matricule
    if ($elect->checkmatr($mat) == "emptymat"){$_SESSION['erreur1'] = "<em>Vous devez renseigner le matricule</em><br>"; $i++;}
    elseif ($elect->checkmatr($mat) == "incorrect") {$_SESSION['erreur1'] = "<em>matricule incorrect</em><br>"; $i++;}
    else
    	$_SESSION['matricule'] = $elect->getmatr();
    
    // verification de la promotion
    if ($elect->checkprom($prom) == "emptyprom"){$_SESSION['erreur3'] = "<em>Vous devez renseigner la promotion</em><br>"; $i++;}
    elseif ($elect->checkprom($prom) == "invalid") {$_SESSION['erreur3'] = "<em>Vous n'etes pas de cette promotion</em><br>"; $i++;}
    else $_SESSION['prom'] = $elect->getprom();

    //verification du mot de passe
    if ($elect->checkmdp($mdp) == "emptymdp"){$_SESSION['erreur2'] = "<em>Vous devez renseigner le mot de passe</em><br>"; $i++;}
    elseif ($elect->connecter() == "echec") {$_SESSION['erreur2'] = "<em>Connexion echoué verifiez votre mot de passe</em><br>"; $i++;}
    elseif ($elect->connecter() == "sorry") {$_SESSION['erreur4'] = "<em>desolé! vous avez deja voté</em><br>"; $i++;}
    else $_SESSION['pwd'] = $elect->getmdp() ;


    if ($i > 0) 
    {
    	$_SESSION['erreurs']  = $i;
    	header('location: connexion.php');
    }
    else{
    	header('location: elire.php');
    }

    echo "==============================================================================<br>";
    foreach ($_SESSION as $key => $value) {
    	echo $key .' : '.$value.'<br>';
    }

    echo "==============================================================================<br>";
    foreach ($_POST as $k => $v) {
    	echo $k .' : '.$v.'<br>';
    }

    echo $elect->connecter();
?>