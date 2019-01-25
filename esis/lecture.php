<?php
$fp = fopen('liste_Etudiants/plk.csv','a+');
$chiffres = 6;
while ($tab = fgetcsv($fp,1000))
{

	$i = 0;

	while ($i < $chiffres) {
		$nbres = mt_rand(0,9);
		$nbr[$i] = $nbres;
		$i++;
	}

	$nombres = null;

	foreach ($nbr as $key) {
		$nombres .= $key;
	}
	$mdp = $nombres;
	echo "<pre>";
	echo $tab[0];
	echo "</pre>";
	$mdp;
	echo $mdp;
	//insert($tab[0], $mdp, 'G3RES', 0);
}
function insert($mat, $mdp, $prom, $vot)
{
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

    $requette = $connexion->prepare('INSERT INTO electeurs(matricule, mdp, promotion, voted) VALUES(:mat, :mdp, :prom, :vot)');
    $requette->bindValue(':mat', $mat);
    $requette->bindValue(':mdp', $mdp);
    $requette->bindValue(':prom', $prom);
    $requette->bindValue(':vot',$vot);
    $requette->execute();
}

//insert('16PK389', '188085296', 'G1', 0);

?>