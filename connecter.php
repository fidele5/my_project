<?php
    session_name('fideleplk');
    session_start();
    
    require_once 'fonctions/classe.php';
    require_once 'fonctions/bdd.php';

    if (isset($_POST['email'], $_POST['mdp'])) {
        $user = new membre();
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $_SESSION['error2'] = null;
        $_SESSION['error1'] = null;
        $i = 0;
        if ($user->connecter($email, $mdp) == 'ok'){
            header('location: debut.php');
        }
        elseif ($user->connecter($email, $mdp) == 'badpwd') {
            $_SESSION['email'] = $email;
            $_SESSION['error2'] = "Vous avez entré un tres mauvais mot de passe<br>";
            $i++; 
            
        }
        else {
            $_SESSION['error1'] = "Vous n'avez pas entré un email valide <br>";
            $i++;
        }
    }
    else {
        $_SESSION['error3'] = "Vous devez remplir tous les champs";
        $i++;
    }
    if ($i>0) {
        $_SESSION['err'] = $i;
        header('location: index.php');
    }
    
?>