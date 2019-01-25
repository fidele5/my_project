<?php
    class elections
    {
        private $matr_electeur, $mdp_electeur, $promotion;

        public function __construct()
        {
            $this->matr_electeur = "";
            $this->mdp_electeur = "";
            $this->promotion = "";
            $this->nom_cand = "";
            $this->id_cand = "";
            $this->nb_voix = "";
            $this->bd_nom_serveur = 'localhost';
            $this->bd_login = 'root';
            $this->bd_mot_de_passe = '';
            $this->bd_nom_bd = 'electionesis';
        }

        public function checkmatr($mat)
        {
            if (empty($mat)) return "emptymat";
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
                $result=$connexion->prepare('SELECT COUNT(*) AS nbr FROM electeurs WHERE matricule = :matr');
                $result->bindValue(':matr',$mat, PDO::PARAM_STR);
                $result->execute();
                $email_free=($result->fetchColumn()==0)?1:0;
                $result->CloseCursor();
                if (!$email_free) return $this->matr_electeur = $mat;
                else return "incorrect";
            }
        }

        public function checkprom($prom)
        {
            if (empty($prom)) return "emptyprom";
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
                $res=$connexion->prepare('SELECT COUNT(*) AS nbr2 FROM electeurs WHERE promotion = :prom AND matricule = :matr');
                $res->bindValue(':prom',$prom, PDO::PARAM_STR);
                $res->bindValue(':matr',$this->matr_electeur, PDO::PARAM_STR);
                $res->execute();
                $email_free=($res->fetchColumn()==0)?1:0;
                $res->CloseCursor();
                if (!$email_free) return $this->promotion = $prom;
                else return "invalid";
            }
        }

        public function checkmdp($mdp)
        {
            if (empty($mdp)) return "emptymdp";
            else $this->mdp_electeur = $mdp;
        }

        public function getmdp()
        {
            return $this->mdp_electeur;
        }

        public function getmatr()
        {
            return $this->matr_electeur;
        }

        public function getprom()
        {
            return $this->promotion;
        }

        public function dejavote($id)
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
            $res=$connexion->prepare('SELECT COUNT(*) AS nbr2 FROM electeurs WHERE id_elec = :moi AND voted = "0"');
            $res->bindValue(':moi',$id, PDO::PARAM_STR);
            $res->execute();
            $email_free=($res->fetchColumn()==0)?1:0;
            $res->CloseCursor();
            if ($email_free) return "voted";
            //else return "ok";
        }

        public function connecter()
        {

            try {
                $connexion = new PDO("mysql:host=" . $this->bd_nom_serveur . ";dbname=" . $this->bd_nom_bd . "", $this->bd_login, $this->bd_mot_de_passe);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            $requette = $connexion->prepare('SELECT id_elec, matricule, mdp, promotion FROM electeurs WHERE mdp = :mdp');
            $requette->bindValue(':mdp', $this->mdp_electeur);
            $requette->execute();
            $req = $requette->fetch();
            $requette->CloseCursor();
            if ($req['mdp'] != $this->mdp_electeur && $req['matricule'] != $this->matr_electeur) 
            {
                return "echec";
            }
            elseif ($this->dejavote($req['id_elec']) == "voted") 
            {
                $this->matr_electeur = null;
                $this->promotion = null;
                $this->mdp_electeur = null;
                return "sorry";
            }
            else
            {
                $_SESSION['matr'] = $req['matricule'];
                $_SESSION['id'] = $req['id_elec'];
                    
            }
            echo $this->dejavote($req['id_elec']);
        }
        
        public function voter($id_cand, $id)
        {
            if ($this->dejavote($id) == "voted") {
                header('location: elire.php');
            }
            else
            {
                $connexion = new PDO("mysql:host=".$this->bd_nom_serveur.";dbname=".$this->bd_nom_bd."", $this->bd_login, $this->bd_mot_de_passe);
                $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $connexion->beginTransaction();
                try 
                {
                    $res=$connexion->prepare('UPDATE candidat SET nbre_voix = nbre_voix + 1 WHERE id_cand = :id');
                    $res->bindValue(':id',$id_cand, PDO::PARAM_STR);
                    $res->execute();
                
                    $voted = $connexion->prepare('UPDATE electeurs SET voted = "1" WHERE id_elec = :id_el');
                    $voted->bindValue(':id_el', $id);
                    $voted->execute();

                    $connexion->commit();
                } catch (Exception $e){
                    $connexion->rollBack();
                    echo "Echec: " . $e->getMessage();
                }
                header('location: elire.php');
            }   
        }

        public function getparticipants()
        {
           try {
                $connexion = new PDO("mysql:host=" . $this->bd_nom_serveur . ";dbname=" . $this->bd_nom_bd . "", $this->bd_login, $this->bd_mot_de_passe);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            $part = $connexion->prepare('SELECT COUNT(*) FROM electeurs WHERE voted  = "1"');
            $part->execute();
            $nb = $part->fetchColumn();
            return $nb; 
        }

        public function getAllelecteurs()
        {
            try {
                $connexion = new PDO("mysql:host=" . $this->bd_nom_serveur . ";dbname=" . $this->bd_nom_bd . "", $this->bd_login, $this->bd_mot_de_passe);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            $part = $connexion->prepare('SELECT COUNT(*) FROM electeurs');
            $part->execute();
            $nb = $part->fetchColumn();
            return $nb;
        }

        public function nbvoix($id_cand)
        {
            try {
                $connexion = new PDO("mysql:host=" . $this->bd_nom_serveur . ";dbname=" . $this->bd_nom_bd . "", $this->bd_login, $this->bd_mot_de_passe);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            $part = $connexion->prepare('SELECT nbre_voix FROM candidat WHERE id_cand = :id');
            $part->bindValue(':id', $id_cand);
            $part->execute();
            $nb = $part->fetch();
            return $nb['nbre_voix'];
        }

        public function comptearebours()
        {
            $annee = date('Y');
            $fin = mktime(0, 0, 0, 1, 30, $annee);
            if ($fin <= time()) return "end";
            else{
                $tps_restant = $fin - time(); 
                $i_restantes = $tps_restant / 60;
                $H_restantes = $i_restantes / 60;
                $d_restants = $H_restantes / 24;
                $s_restantes = floor($tps_restant % 60); // Secondes restantes
                $i_restantes = floor($i_restantes % 60); // Minutes restantes
                $H_restantes = floor($H_restantes % 24); // Heures restantes
                $d_restants = floor($d_restants); // Jours restantss

                setlocale(LC_ALL, 'fr_FR');
            }
        }

        public function avantvote()
        {
            $annee = date('Y');
            $fin = mktime(0, 0, 0, 1, 28, $annee);
            if ($fin <= time()) return "end";
            else{
                $tps_restant = $fin - time(); 
                $i_restantes = $tps_restant / 60;
                $H_restantes = $i_restantes / 60;
                $d_restants = $H_restantes / 24;
                $s_restantes = floor($tps_restant % 60); // Secondes restantes
                $i_restantes = floor($i_restantes % 60); // Minutes restantes
                $H_restantes = floor($H_restantes % 24); // Heures restantes
                $d_restants = floor($d_restants); // Jours restantss

                setlocale(LC_ALL, 'fr_FR');
            }
        }
    }
?>