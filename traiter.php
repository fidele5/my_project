<?php
	session_name("fideleplk");
	session_start();

	require_once 'fonctions/bdd.php';
	require_once 'fonctions/classe.php';

	$texte = $_POST['texte'];
	$titre = $_POST['titre'];
	$date = date('d-m-Y');

	if (isset($texte) && isset($titre)) {
		$requette = $connexion->prepare('INSERT INTO actus(titre_actu, id_auteur, text_actu, nb_vues, date_post, nb_likes, nb_dislike) VALUES(:titre, :id, :texte, 0, :dat, 0,0)');
		$requette->bindParam(':titre', $titre);
		$requette->bindParam(':id', $_SESSION['id']);
		$requette->bindParam(':texte', $texte);
		$requette->bindParam(':dat', $date);
		$req = $requette->execute();
		if ($req) {
			echo "Ok";
		}
		else
			echo "echec";
	}
	else
		echo "empty";
?>