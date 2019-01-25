<?php
	$bd_nom_serveur='localhost';
    $bd_login='root';
    $bd_mot_de_passe='';
    $bd_nom_bd='electionesis';
    try 
    {
        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e) 
    {
        die('Erreur : ' . $e->getMessage());
    }
?>