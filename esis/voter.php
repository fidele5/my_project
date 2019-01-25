<?php
	session_name('election');
	session_start();

	require_once('election.php');
	require_once 'bdd.php';

	$id_cand = (int)htmlspecialchars($_GET['id']);
	if (is_int($id_cand)) {
		$id = $_SESSION['id'];

		$voter = new elections();

		$voter->voter($id_cand, $id);

		$vote = $connexion->prepare('INSERT INTO prom(id_electeur, id_candidat) VALUES(:id_elec, :id_cand)');
        $vote->bindValue(':id_elec', $id);
        $vote->bindValue(':id_cand',$id_cand, PDO::PARAM_STR);
        $vote->execute();
	}
	else{
		header('location: elire.php');
	}

?>