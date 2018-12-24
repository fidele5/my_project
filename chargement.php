<?php
	$dernier = (int)$_GET['f'];
	$bd_nom_serveur='localhost';
	$bd_login='root';
	$bd_mot_de_passe='';
	$bd_nom_bd='plk2';
	try 
	{
		$connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e) 
	{
		die('Erreur : ' . $e->getMessage());
	}
	if ($connexion) 
	{
		$commen = $connexion->prepare("SELECT * FROM actus INNER JOIN espace ON espace.membre_id = actus.id_auteur WHERE id_actu > :last ORDER BY id_actu DESC ");
		$commen->bindValue(':last', $dernier, PDO::PARAM_INT);
		$commen->execute();
		$message = null;
		while ($donnees=$commen->fetch()) 
		{
			$message.= "<p id=\"" . $donnees['id_actu'] . "\" style='padding : 8px; width : 80%; border-bottom : 1px solid silver; margin-bottom : 5px;'>
				<table>
					<tr>
						<td><div id='img'><img src='fichier/".$donnees['membre_avatar']."' id='icon'/></div></td>
						<td> <div id='contenu'><span style='color : #009688;' >".$donnees['titre_actu']."</span><br>".$donnees['text_actu'].'<br> Publié le : '.$donnees['date_post']."<br> par : <a href=''>".$donnees['membre_pseudo']."</a></div></td>
					</tr>
				</table>
			</p>";
		}	
		echo $message;
	}
	else
		echo "Echec de connexion a la base des donnees";
?>