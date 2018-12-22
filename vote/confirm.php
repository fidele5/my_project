<?php
	session_name('vote');
	session_start();

	require_once 'vote.php';
	require_once 'bdd.php';

	$id = $_GET['id'];
	$idel = $_SESSION['id'];
	$cat = $_GET['cat'];
	switch ($cat) {
		case 1:
			$vote = $connexion->prepare('UPDATE candidat SET nb_oui_pres = nb_oui_pres +1, id_electeur = :idel WHERE id_candidat = :id');
			$vote->bindValue('id', $id);
			$vote->bindValue('idel', $idel);
			$voted = $vote->execute();
			if ($voted) {
				$_SESSION['presvoted'] = 'voté';
				header('location: voter.php');
			}
			else
				return 'failed';
			break;
		case 2:
			$vote = $connexion->prepare('UPDATE candidat SET nb_oui_vice = nb_oui_vice +1, id_electeur = :idel WHERE id_candidat = :id');
			$vote->bindValue('id', $id);
			$vote->bindValue('idel', $idel);
			$voted = $vote->execute();
			if ($voted) {
				$_SESSION['presvoted'] = 'voté';
				header('location: voter.php');
			}
			else
				return 'failed';
			break;
		case 3:
			$vote = $connexion->prepare('UPDATE candidat SET nb_oui_coord = nb_oui_coord +1, id_electeur = :idel WHERE id_candidat = :id');
			$vote->bindValue('id', $id);
			$vote->bindValue('idel', $idel);
			$voted = $vote->execute();
			if ($voted) {
				$_SESSION['presvoted'] = 'voté';
				header('location: voter.php');
			}
			else
				return 'failed';
			break;
		case 4:
			$vote = $connexion->prepare('UPDATE candidat SET nb_oui_vcoor = nb_oui_vcoor +1, id_electeur = :idel WHERE id_candidat = :id');
			$vote->bindValue('id', $id);
			$vote->bindValue('idel', $idel);
			$voted = $vote->execute();
			if ($voted) {
				$_SESSION['presvoted'] = 'voté';
				header('location: voter.php');
			}
			else
				return 'failed';
			break;
		
		default:
			# code...
			break;
	}
	
?>