<?php
/**
	=============================== Notice ========================================
	Classe permettant de faire la validation d'un formulaire et quelques options d'un espace membre 
	Si vous voulez utiliser la classe vous devriez modifier les variables de connexion à la base des données,
	modifier les champs et les tables se trouvant dans les requetes mysql. ou si vous voulez utiliser les memes tables : 
	ouvrez le fichier contenant le code de création des tables(base des données).
	dans le fichier essai.php se trouve l'exemple d'utilisation de cette classe.

	fideleplk@gmail.com
* 
*  @author    Fideleplk <fideleplk@gmail.com>
*  @copyright 2018 Fideleplk
*/
//@auteur fideleplk
class membre
	{
		public $pseudo, $email, $mdp, $mdpverif, $avatar, $date;
		private $bd_nom_serveur, $bd_login, $bd_mot_de_passe,$bd_nom_bd;

		public function __construct()
		{
			$this->pseudo = "";
			$this->email = "";
			$this->emailverif = "";
			$this->mdp = "";
			$this->mdpverif = "";
			$this->avatar = null;
			$this->date = "";
			$this->bd_nom_serveur = 'localhost';
			$this->bd_login = 'root';
			$this->bd_mot_de_passe = '';
			$this->bd_nom_bd = 'plk2';
		}

		// verification du pseudo
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

		// Verification du mot de passe
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

		// Comparaison de deux mot de passe
		public function confirmdp($mdpverif)
		{
			if ($this->mdp != $mdpverif) return "Nconf";
			else $this->mdpverif = $mdpverif;
		}

		// verification de l'adresse email
		public function checkmail($email)
		{
			$domaine = strstr($email, '@');
			if (empty($email)) return "vide";
			elseif (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $email)) return 'isnt';
			//elseif(!checkdnsrr($domaine, 'MX')) return 'mamaee';
			else
			{
				try 
				{
					$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
				    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} 
				catch (Exception $e) 
				{
					die('Erreur : ' . $e->getMessage());
				}
				$result=$connexion->prepare('SELECT COUNT(*) AS nbr FROM espace WHERE membre_email = :email');
				$result->bindValue(':email',$email, PDO::PARAM_STR);
				$result->execute();
				$email_free=($result->fetchColumn()==0)?1:0;
				$result->CloseCursor();
				if (!$email_free) return "exists";
				else $this->email = $email;
			}
		}

		// upload et verification de la photo / fichier
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

		// verification de la date de naissance
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


		// verification du captcha
		public function captcha($captcha)
		{
			if (empty($captcha)) return "emptyimg";
			elseif ($captcha != $_SESSION['captcha']) return "invalid";
			else return "ok"; 
		}

		// insertion des donnees dans la base des données ☺
		public function inserer()
		{
		    try 
			{
				$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
			    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
			catch (Exception $e) 
			{
				die('Erreur : ' . $e->getMessage());
			}
		    $insert = $connexion->prepare('INSERT INTO espace(membre_pseudo, membre_email, membre_mdp, membre_avatar, membre_date) VALUES(:pseudo, :email, :mdp, :avatar, :dat)');
			$insert->bindValue(':pseudo', $this->pseudo);
			$insert->bindValue(':email', $this->email);
			$insert->bindValue(':mdp', $this->mdp);
			$insert->bindValue(':avatar', $this->avatar);
			$insert->bindValue(':dat', strtotime($this->date));
			$insert->execute();
			$insert->CloseCursor();
		}

		// actualiser la session (voir se souvenir de moi)
		public function Actualisersession()
		{
			if (isset($_COOKIE['pseudo']) && isset($_COOKIE['id'])) 
			{
			    try 
				{
					$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
				    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} 
				catch (Exception $e) 
				{
					die('Erreur : ' . $e->getMessage());
				}
			    $requette = $connexion->prepare('SELECT membre_id, membre_pseudo, membre_email FROM espace WHERE membre_id = :id');
				$requette->bindValue(':id', $_COOKIE['id']);
				$requette->execute();
				$req = $requette->fetch();
				$requette->CloseCursor();

			    if ($req['membre_pseudo'] == $_COOKIE['pseudo']) {
			    	$_SESSION['pseudo'] = $req['membre_pseudo'];
			    	$_SESSION['id'] = $req['membre_id'];
			    	header('location: page.php');
			    }
			}
			else
				header('location: index.php');
		}

		// connexion
		public function connexion($pseudo, $mdp, $cookie)
		{
			$this->pseudo = $pseudo;
			$this->mdp = $mdp;
			try 
			{
				$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
			    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
			catch (Exception $e) 
			{
				die('Erreur : ' . $e->getMessage());
			}
			$requette = $connexion->prepare('SELECT membre_id, membre_pseudo, membre_email FROM espace WHERE membre_mdp = :mdp');
			$requette->bindValue(':mdp', $this->mdp);
			$requette->execute();
			$req = $requette->fetch();
			$requette->CloseCursor();
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

		// envoyer un email
		public function Send_email()
		{
			$msg = "<!DOCTYPE html>
					<html>
					<head>
						<title>Confiirmarion</title>
					</head>
					<body>
						<p>
							Votre compte a été enregistré avec succes nous vous prions de consulter ce lien pour vous connecter<br>
							<a href='index.php>se connecter</a>'
						</p>
					</body>
					</html>";
			$header = "From: \"VideosTube\"<fideleplk@gmail.com>" . "\r\n";
			$header.= "Reply-to: \"VideosTube\" <fideleplk@gmail.com>" . "\r\n";
			$header.= "MIME-Version: 1.0" . "\r\n";
			//=====Ajout du message au format html
			$msg .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . "\r\n";
			$header.= 'Cc: "Contact" <fideleplk@gmail.com>' . "\r\n";
			$header.= 'Bcc: "Contact" <fideleplk@yahoo.com>' . "\r\n";
			//=====Envoi de l'e-mail.
			$titre = "Email-from";
			$sent = mail($this->email, $titre, $msg, $header);
			if ($sent) return "sent";
			else return "error";		
		}

		// reception d'un email
		public function receive_email($login, $mdp)
		{
			$boitmail = imap_open("{mail.google.com:143}INBOX", $login, $mdp);
			$verifier = imap_check($boitmail);
			$nbmsg = imap_num_msg($boitmail);
			try 
			{
				$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
				$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
			catch (Exception $e) 
			{
				die('Erreur : ' . $e->getMessage());
			}

			$i = $connexion->lastInsertId() +1;
			for ($i=1; $i <= $nbmsg ; $i++) 
			{ 
			 	$entete = imap_header($boitmail, $i);
			 	echo $entete->Subject."\n";
			 	echo $entete->from[0]."\n";
			 	$msg = imap_body($boitmail, $i);
			 	echo $msg;
			 	$connecter = $connexion->prepare('INSERT INTO msgbox(titre, expediteur, message) VALUES(:titre, :exp, :msg)');
			 	$connecter->bindValue(':titre', $entete->Subject);
			 	$connecter->bindValue(':exp', $entete->from[0]);
			 	$connecter->bindValue(':msg', $msg);
			 	$connecter->execute();
			 	$connecter->CloseCursor();

			} 
			imap_expunge($boitmail);
			imap_close($boitmail);
		}

		// localiser un membre grace à son adresse ip
		public function localiser()
		{
			$gi = geoip_open(realpath("localisation/GeoLiteCity.dat"),GEOIP_STANDARD);
			$record = geoip_record_by_addr($gi,$_SERVER['REMOTE_ADDR']);
			$la = $record->latitude;
			$lo = $record->longitude;
			$url = "http://maps.google.com/maps/geo?output=csv&q=".$la.",".$lo;
			if($csv = file_get_contents($url))
			{
				if(substr($csv,0,3)!=200)
				{
					die("Erreur");
				}
				else
				{
					$adresse = substr($csv, 7, -1);
					return $adresse;
				}
			}
			else
			{
				return "Erreur";
			}
		}

		// verifier le nombre de membres connectés
		public function connected()
		{
			try 
			{
				$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
				$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
			catch (Exception $e) 
			{
				die('Erreur : ' . $e->getMessage());
			}

			$connect = $connexion->prepare('SELECT COUNT(*) FROM connectes WHERE ip = :ip');
			$connect->bindValue(':ip', $_SERVER['REMOTE_ADDR']);
			$connect->execute();
			$exists=($connect->fetchColumn()==0)?1:0;
			$connect->CloseCursor();
			if (!$exists){
				$connect = $connexion->prepare('UPDATE connectes SET duree=:temps WHERE ip=:ip');
				$connect->bindValue(':temps', time());
				$connect->bindValue('ip', $_SERVER['REMOTE_ADDR']);
				$connect->execute();
				$connect->CloseCursor();
			}
			else{
				$connect = $connexion->prepare('INSERT INTO connectes(duree, ip) VALUES(:temps, :ip)');
				$connect->bindValue(':temps', time());
				$connect->bindValue('ip', $_SERVER['REMOTE_ADDR']);
				$connect->execute();
				$connect->CloseCursor();
			}

			$duree = time() - (60*5);

			$val = $connexion->prepare('DELETE FROM connectes WHERE duree < :temps');
			$val->bindValue(':temps', $duree);
			$val->execute();
			$val->CloseCursor();

			$plk = $connexion->prepare('SELECT COUNT(*) FROM connectes');
			$plk->execute();
			$connected=$plk->fetchColumn();
			$plk->CloseCursor();

			return $connected;
		}

		// modifier le profil
		public function updateprofil($pseudo, $email, $mdp, $photo, $date)
		{
			try 
			{
				$connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
				$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
			catch (Exception $e) 
			{
				die('Erreur : ' . $e->getMessage());
			}

			$update = $connexion->prepare('UPDATE espace SET membre_pseudo = :pseudo, membre_email = :email, membre_mdp = :mdp, membre_avatar = :photo, membre_date = :dat WHERE membre_id = :id');
			$update->bindValue(':pseudo', $pseudo);
			$update->bindValue(':email', $email);
			$update->bindValue(':mdp', $mdp);
			$update->bindValue(':photo', $photo);
			$update->bindValue(':dat', strtotime($date));
			$update->execute();
			$update->CloseCursor();
		}
	}//fin classe
?>