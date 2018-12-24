<?php
    session_name('fideleplk');
    session_start();

   require_once 'fonctions/user.php';
   $user = new user();

   $user->ActualiserSession();

    foreach ($_COOKIE as $key => $value) {
        echo $key.' : '.$value.'<br>';
    }
?>
<li><a href="<?=$_SERVER['PHP_SELF']?>">Acceuil</a></li>
<li><a href="profil.php"><?=$pseudo?></a></li>
<li><a href="messages.php">Messages</a></li>
<li><a href="notification.php">Notifications</a></li>
<li><a href="deconnexion.php">Deconnexion</a></li>