<?php 
		$date = $_POST['date'];
		$nom = $_POST['Pseudo'];
		$avatar_erreur = NULL;
		$avatar_erreur1 = NULL;
		$avatar_erreur2 = NULL;
		$avatar_erreur3 = NULL;
		$i = 0;
		if ($date == '' && $nom == '')
		{
			echo "OH OH?!";
		}
		else {
				if (preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#is', $date))
			{
				echo $date.'<br>';
				$anniv = preg_replace('#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#is','$3', $date);
				$day = preg_replace('#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#is', '$1', $date);
				$month = preg_replace('#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#is', '$2', $date);
				$jj  = date('d');
				$mm = date('m');
				$an = date('Y');
				$fet = $an-$anniv;
				echo "Vous avez ".$fet.' ans <br>' ;
				if ($fet <=10)
				{
					echo $nom.' Vous êtes trop jeune pour ce site!';
				}
				elseif ($fet > 10) {
					echo "Bienvenue dans la cour de miracle ".$nom.'<br>';
				
					if ($jj==$day && $mm ==$month) {
						echo "C'est votre anniversaire";
					}
				}
			}
			else{
				echo 'Entrer la date qui convient';
			}
		}

		//Vérification de l'avatar
if (!empty($_FILES['avatar']['size']))
{
	//On définit les variables :
	$maxsize = 50072; //Poid de l'image
	$maxwidth = 500; //Largeur de l'image
	$maxheight = 500; //Longueur de l'image
	//Liste des extensions valides
	$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png','bmp','mp3' );
	if ($_FILES['avatar']['error'] > 0)
	{
		$avatar_erreur = "Erreur lors du tranfsert de l'avatar : ";
	}
	if ($_FILES['avatar']['size'] > $maxsize)
	{
		$i++;
		$avatar_erreur1 = "Le fichier est trop gros :
		(<strong>".$_FILES['avatar']['size']." Octets</strong>contre <strong>".$maxsize." Octets</strong>)";
	}
	$image_sizes = getimagesize($_FILES['avatar']['tmp_name']);
	if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight)
	{
		$i++;
		$avatar_erreur2 = "Image trop large ou trop longue :
		(<strong>".$image_sizes[0]."x".$image_sizes[1]."</strong> contre <strong>".$maxwidth."x".$maxheight."</strong>)";
	}
	$extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.') ,1));
	if (!in_array($extension_upload,$extensions_valides) )
	{
		$i++;
		$avatar_erreur3 = "Extension de l'avatar
		incorrecte";
	}
}
echo'<p>'.$avatar_erreur1.'</p>';
echo'<p>'.$avatar_erreur2.'</p>';
echo'<p>'.$avatar_erreur3.'</p>';
function move_avatar($avatar)
{
$extension_upload = strtolower(substr( strrchr($avatar['name'],'.') ,1));
$name = time();
$nomavatar = str_replace(' ','',$name).".".$extension_upload;
$name =str_replace('','',$name).".".$extension_upload;
move_uploaded_file($avatar['tmp_name'],$name);
return $nomavatar;
}
	if (!empty($_FILES['avatar']['size']))
	{
		$nomavatar=move_avatar($_FILES['avatar']);
		if(in_array($extension_upload, $extensions_valides))
		{
			echo "<img src='".$nomavatar."'>";
		}
		else
			echo "<video src='".$nomavatar."' width = '150px' controls></video>";
		
	}
?>