<?php
	session_name('fideleplk');
	session_start();
	session_destroy();
	header('location: index.php');
?>