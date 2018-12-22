<?php
	/**
	 * 
	 */
	class Election 
	{

		private $NomElecteur, $Mdpelecteur, $idElecteur, $Votelecteur, $cells;
		
		function __construct()
		{
			$this->NomElecteur  = '';
			$this->Mdpelecteur  = '';
			$this->idElecteur  = '';
			$this->Votelecteur  = '';
			$this->cells = "";
		}

		public function Connecter($nom, $mdp, $cellule)
		{
			$this->NomElecteur = $nom;
			$this->Mdpelecteur = $mdp;
			$this->cells = $cellule;
			
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd='election';
		    try 
		    {
		        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$insert = $connexion->prepare('SELECT * FROM electeur WHERE nom_electeur = :nom');
				$insert->bindValue(':nom', $this->NomElecteur);
				$insert->execute();
				$data = $insert->fetch();
			}
			catch (Exception $e) 
		    {
		        die('Erreur : ' . $e->getMessage());
		    }

		    if ($data['mdp_electeur']!= $this->Mdpelecteur) 
		    {
		    	return 'wrong';
		    }
		    elseif ($data['vote_electeur'] > 0) {
		    	return 'voted';
		    }
		    elseif ($data['id_cellule'] != $cellule) {
		    	return 'none';
		    }
		    else
		    {
		    	$_SESSION['pseudo'] = $data['nom_electeur'];
		    	$_SESSION['id'] = $data['id_electeur'];
		    	$_SESSION['id_cellule'] = $affich['id_cellule'];
		    	return 'ok';
		    }
		}

		public function proclam()
		{
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd='election';

		    $insert = $connexion->prepare('SELECT nom_cand, nb_oui, nb_non FROM candidat');
			$insert->execute();
			while ($data = $insert->fetch()) {
				echo $data['nom_cand'].' '.$nb_oui.' '.$nb_non;
			}
		}
	}
?>