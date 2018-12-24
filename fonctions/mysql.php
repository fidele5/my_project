<?php
public function afficher($table, $bdd)
		{
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd=$bdd;
		    try 
		    {
		        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$requette = $connexion->prepare('SELECT * FROM '.$table);
				$requette
				->execute();
				$afficher = $insert->fetchAll();
				return $afficher;
		    }
		    catch (Exception $e) 
		    {
		        die('Erreur : ' . $e->getMessage());
		    }
		}

		public function count($table, $bdd)
		{
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd=$bdd;
		    try 
		    {
		        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$requette = $connexion->prepare('SELECT COUNT(*) FROM '.$table);
				$requette->execute();
				$afficher = $insert->fetchColumn();
				return $afficher;
		    }
		    catch (Exception $e) 
		    {
		        die('Erreur : ' . $e->getMessage());
		    }
		}

		public function avg($table, $bdd, $champ)
		{
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd=$bdd;
		    try 
		    {
		        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$requette = $connexion->prepare('SELECT AVG($champ) FROM '.$table);
				$requette->execute();
				$afficher = $insert->fetchAll();
				return $afficher;
		    }
		    catch (Exception $e) 
		    {
		        die('Erreur : ' . $e->getMessage());
		    }
		}

		public function somme($table, $bdd, $champ)
		{
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd=$bdd;
		    try 
		    {
		        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$requette = $connexion->prepare('SELECT SUM($champ) FROM '.$table);
				$requette->execute();
				$afficher = $insert->fetchAll();
				return $afficher;
		    }
		    catch (Exception $e) 
		    {
		        die('Erreur : ' . $e->getMessage());
		    }
		}
?>