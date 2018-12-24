<?php
class membre
	{
		public $pseudo, $email, $mdp, $mdpverif, $avatar, $date;
		
		public function __construct()
		{
			$this->pseudo = "";
			$this->email = "";
			$this->emailverif = "";
			$this->mdp = "";
			$this->mdpverif = "";
			$this->avatar = null;
			$this->date = "";
		}

		public function checkpseudo($pseudo)
		{
			if (empty($pseudo)) return "vide";
			elseif (strlen($pseudo) < 4 ) return "court";
			elseif (strlen($pseudo) > 64) return "long";

			else
			{
				$this->pseudo = $pseudo;

			}
		}

		public function checkmdp($mdp)
		{
			if ($mdp == '') return 'vide';
			else if(strlen($mdp) < 4) return 'court';
			else if(strlen($mdp) > 50) return 'long';
			else 
			{
				if (!preg_match('#[0-9]{1,}#', $mdp)) return 'nofigure';
				else if (!preg_match('#[A-Z]{1,}#', $mdp)) return 'noupcap';
				else $this->mdp = $mdp;
			}
		}

		public function confirmdp($mdpverif)
		{
			if ($this->mdp != $mdpverif) return "Nconf";
			else $this->mdpverif = $mdpverif;
		}

		public function checkmail($email)
		{
			if (empty($email)) return "vide";
			elseif (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $email)) return 'isnt';
			else{
				$connexion = new PDO("mysql:host=localhost;dbname=plk2", 'root', '');
				$result=$connexion->prepare('SELECT COUNT(*) AS nbr FROM espace WHERE membre_mail = :email');
				$result->bindValue(':email',$email, PDO::PARAM_STR);
				$result->execute();
				$email_free=($result->fetchColumn()==0)?1:0;
				$result->CloseCursor();
				if (!$email_free) return "exists";
				else $this->email = $email;
			}
		}

		public function avatar($avatar)
		{
			foreach($_FILES as $file)
			{
			    $extensions_valides = array('jpg' , 'jpeg' , 'gif' , 'png');
			    $text = substr(strrchr($file['name'], '.'), 1);
			    if (in_array($text, $extensions_valides)) {
			         $tmp_name = $file['tmp_name'];
			         $file['name']= explode(".", $file['name']);
			         $file['name']= $file['name'][0].".".$text;
			         $destination = 'fichier/'.$file['name'];
			         move_uploaded_file($tmp_name,$destination);
			    }
			    if($file['error'] == UPLOAD_ERR_OK)
			    {
			    	$this->avatar = $file['name'];
			    }
			    else
			    {
			        switch ($file['error'])
			        {    
			                case 1: // UPLOAD_ERR_INI_SIZE    
			                return "long";    
			                break;    
			                case 2: // UPLOAD_ERR_FORM_SIZE    
			                return "grand";
			                break;    
			                case 3: // UPLOAD_ERR_PARTIAL    
			                return "echec";    
			                break;    
			                case 4: // UPLOAD_ERR_NO_FILE    
			                return "vide";
			                break;    
			        }    
			    }    
			}
		}

		public function verifdate($date)
		{
			if (empty($date)) return "vide";
			else 
			{
				if (preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#is', $date))
				{
					$this->date = $date;
				}
				else return "badate";
			}
		}

		public function inserer()
		{
			$bd_nom_serveur='localhost';
		    $bd_login='root';
		    $bd_mot_de_passe='';
		    $bd_nom_bd='plk2';
		    try 
		    {
		        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$insert = $connexion->prepare('INSERT INTO espace(membre_pseudo, membre_email, membre_mdp, membre_avatar, membre_date) VALUES(:pseudo, :email, :mdp, :avatar, :dat)');
				$insert->bindValue(':pseudo', $this->pseudo);
				$insert->bindValue(':email', $this->email);
				$insert->bindValue(':mdp', $this->mdp);
				$insert->bindValue(':avatar', $this->avatar);
				$insert->bindValue(':dat', strtotime($this->date));
				$insert->execute();
		    }
		    catch (Exception $e) 
		    {
		        die('Erreur : ' . $e->getMessage());
		    }
		}

		public function Actualisersession()
		{
			if (isset($_COOKIE['pseudo']) && isset($_COOKIE['id'])) {
				$bd_nom_serveur='localhost';
			    $bd_login='root';
			    $bd_mot_de_passe='';
			    $bd_nom_bd='plk2';
			    try 
			    {
			        $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
			        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$requette = $connexion->prepare('SELECT membre_id, membre_pseudo, membre_email FROM espace WHERE membre_id = :id');
					$requette->bindValue(':id', $_COOKIE['id']);
					$requette->execute();
					$req = $requette->fetch();
			    }
			    catch (Exception $e) 
			    {
			        die('Erreur : ' . $e->getMessage());
			    }
			    if ($req['membre_pseudo'] == $_COOKIE['pseudo']) {
			    	$_SESSION['pseudo'] = $req['membre_pseudo'];
			    	$_SESSION['id'] = $req['membre_id'];
			    	header('location: page.php');
			    }
			}
			else
				return "ko";
		}

		public function connexion($pseudo, $mdp, $cookie)
		{
			$this->pseudo = $pseudo;
			$this->mdp = $mdp;
			$bd_nom_serveur='localhost';
			$bd_login='root';
			$bd_mot_de_passe='';
			$bd_nom_bd='plk2';

			try 
			{
				$connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
			    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$requette = $connexion->prepare('SELECT membre_id, membre_pseudo, membre_email FROM espace WHERE membre_mdp = :mdp');
				$requette->bindValue(':mdp', $this->mdp);
				$requette->execute();
				$req = $requette->fetch();

			} 
			catch (Exception $e) 
			{
				die('Erreur : ' . $e->getMessage());
			}

			if ($req['membre_pseudo']!=$this->pseudo) {
				return 'incorrect';
			}
			else
			{
				$_SESSION['pseudo'] = $req['membre_pseudo'];
				$_SESSION['id'] = $req['membre_id'];

				if (isset($cookie)) {
					$expire = time() + 365*24*3600;
                    setcookie('pseudo', $this->pseudo, $expire);
                    setcookie('id', $req['membre_id'], $expire);
				}
				header('location: page.php');
			}


		}
	}//fin classe
?>