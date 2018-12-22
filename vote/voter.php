<?php
	session_name('vote');
	session_start();

	require_once 'vote.php';
	require_once 'bdd.php';

	if (!isset($_SESSION['pseudo']) && !isset($_SESSION['mdp']) && !isset($_SESSION['cellule'])) {
		header('location : connexion.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		voter
	</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="main2/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="main2/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="main2/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="main2/main.js"></script>
</head>
<body>
	<style type="text/css">
	#icon{
		display: inline-block;
		width: 48px;
		height: 42px;
		text-align: center;
		line-height: 41px;
		border-radius: 50px;
		font-size: 17px;
		color: #fff;
		background: #a5a5a5;
		font-family: sans-serif;
	}
	body{
		font-family: sans-serif;
	}
</style>
	<h1>Passons aux choses serieuses</h1>
<?php
	echo "<span id='icon'>".strtoupper($_SESSION['pseudo'][0])."</span> Bonjour Mr : ".$_SESSION['pseudo'];
	$valid = $connexion->prepare("SELECT electeur.id_cellule, cellules.id_cellule, cellules.nom_cellule, electeur.vote_electeur FROM electeur INNER JOIN cellules ON electeur.id_cellule=cellules.id_cellule WHERE id_electeur  = :id");
	$valid->bindValue(':id', $_SESSION['id']);
	$valid->execute();
	$donnees = $valid->fetch();
?>
<p>
	Règle à suivre : <br>
	<ul>
		<li>Pour la présidence vous pouvez voter ou non votre candidat favori</li>
		<li>Pour les cellules vous ne devez voter que le candidat de votre cellule [un coordonateur ou si "il existe" un vice] </li>
	</ul>
</p>
<p>
	<h2>Commencons!</h2>
	<fieldset><legend>Presidence</legend>
			<?php
				$cand = $connexion->prepare('SELECT nom_candidat, id_candidat, poste_candidat, nb_oui_pres, nb_oui_vice, id_electeur, cat_cand FROM candidat WHERE cat_cand  = 1 OR cat_cand = 2');
				$cand->execute();
				while ($data = $cand->fetch()) {
					if ($data['id_electeur'] == $_SESSION['id']) {
						if ($data['cat_cand'] == 1) {
							echo $data['poste_candidat'].' : '.$data['nom_candidat'].' <em>Voté</em> nbvote('.$data['nb_oui_pres'].')<br>';
						}
						else
							echo $data['poste_candidat'].' : '.$data['nom_candidat'].' <em>Voté</em> nbvote('.$data['nb_oui_vice'].')<br>';
						
					}
					else
						echo $data['poste_candidat'].' : '.$data['nom_candidat'].' <a href="confirm.php?id='.$data['id_candidat'].'&cat='.$data['cat_cand'].'">Voter</a><br>';
				}
			?> 
	</fieldset>
		<fieldset><legend>Cellules</legend>
			<h3><?= $donnees['nom_cellule']?></h3>
			<div id="div1">
					<?php
							$nb = 0;
							$nbvote = $connexion->prepare('SELECT COUNT(id_electeur) FROM candidat WHERE id_cellule = :id AND id_electeur  = :moi');
							$nbvote->bindValue(':moi', $_SESSION['id']);
							$nbvote->bindValue(':id', $donnees['id_cellule']);
							$nbvote->execute();
							$nb = $nbvote->fetchColumn();

							$cand = $connexion->prepare('SELECT nom_candidat, id_candidat, poste_candidat, nb_oui_coord, nb_oui_vcoor, id_electeur, cat_cand, id_electeur FROM candidat WHERE id_cellule = :id');
							$cand->bindValue(':id',$donnees['id_cellule']);
							$cand->execute();
							while ($data = $cand->fetch()) {
									if ($data['id_electeur'] == $_SESSION['id']) {
										if ($data['cat_cand'] == 4) {
											echo $data['poste_candidat'].' : '.$data['nom_candidat'].' <em>Voté</em> nbvote('.$data['nb_oui_vcoor'].')<br>';
										}
										else
											echo $data['poste_candidat'].' : '.$data['nom_candidat'].' <em>Voté</em> nbvote('.$data['nb_oui_coord'].')<br>';	
									}
									elseif (($data['cat_cand'] == 3) && ($nb >0))
										echo $data['poste_candidat'].' : '.$data['nom_candidat'].' nbvote('.$data['nb_oui_coord'].')<br>';
									else
										echo $data['poste_candidat'].' : '.$data['nom_candidat'].' <a href="confirm.php?id='.$data['id_candidat'].'&cat='.$data['cat_cand'].'">Voter</a><br>';
							}
					?>
			</div>
		</fieldset>
	<a href="terminer.php">Terminer</a>
</p>
</body>
</html>
