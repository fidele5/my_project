<?php
	session_name('election');
	session_start();
	session_destroy();
	header("location: connexion.php");
?>