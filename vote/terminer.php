<?php
	session_name('vote');
	session_start();
	session_destroy();
	header('location: connexion.php');
?>