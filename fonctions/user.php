<?php
    class user
    {
        private $id, $pseudo;
        public function ActualiserSession()
        {
            if(isset($_SESSION['id']) && isset($_SESSION['pseudo'])) //Vérification id
            {
                $this->id = $_SESSION['id'];
                $this->$pseudo = $_SESSION['pseudo'];
                $bd_nom_serveur='localhost';
                $bd_login='root';
                $bd_mot_de_passe='';
                $bd_nom_bd='plk2';
                try 
                {
                    $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
                    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $retour = $connexion->prepare("SELECT membre_id, membre_pseudo FROM espace WHERE membre_id = :id");
                    $retour->bindvalue(':id', $this->id, PDO::PARAM_INT);
                    $retour->execute();
                    $data=$retour->fetch();
                }
                catch (Exception $e) 
		        {
		            die('Erreur : ' . $e->getMessage());
		        }
                if($this->pseudo != $data['membre_pseudo'])
                {
                    header('location: index.php');
                }
                else
                {
                    $_SESSION['id'] = $data['membre_id'];
                    $_SESSION['pseudo'] = $data['membre_pseudo'];
                    header('location: debut.php');
                }
            }
            elseif(isset($_COOKIE['id']) && isset($_COOKIE['pseudo']))
            {
                $this->id = $_COOKIE['id'];
                $this->pseudo = $_COOKIE['pseudo'];
                $bd_nom_serveur='localhost';
                $bd_login='root';
                $bd_mot_de_passe='';
                $bd_nom_bd='plk2';
                try 
                {
                    $connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
                    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $retour = $connexion->prepare("SELECT membre_id, membre_pseudo FROM membres WHERE membre_id = :id");
                    $retour->bindValue(':id', $this->id);
                    $retour->execute();
                    $data=$retour->fetch();
                }
                catch (Exception $e) 
		        {
		            die('Erreur : ' . $e->getMessage());
		        }
                if($this->pseudo != $data['membre_pseudo'])
                {
                    header('location: index.php');
                }
                else
                {
                    $_SESSION['id'] = $data['membre_id'];
                    $_SESSION['pseudo'] = $data['membre_pseudo'];
                    header('location: debut.php');
                }
            }
            else 
            {
                header('location: index.php');
            }
        }
        public function vider_cookie()
        {
            foreach($_COOKIE as $cle => $element)
            {
                setcookie($cle, '', time()-3600);
            }
        }
    }
    
?>