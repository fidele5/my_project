<?php 
	session_name("election");
	session_start();
	require_once 'election.php';
	require_once 'bdd.php';

	if (isset($_SESSION['id']) && isset($_SESSION['matr'])) {
		$vals = $connexion->prepare('SELECT * FROM candidat');
		$vals->execute();
	}
	else
		header('location: connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Voter</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css"/>
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
	<link href="css/fontawesome-all.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script type="text/javascript" src="compte.js"></script>
	
</head>
<body>
	<h1>Liste des candidats</h1>
		<?php
		$elect = new elections();
		if ($elect->avantvote()=="end") 
		{
			if ($elect->comptearebours() == "end") {
			header('location: stats.php');
			}
			else{
				if ($elect->dejavote($_SESSION['id']) == "voted") 
				{
					echo "<em>Vous avez déjà voté! Cependant, vous allez attendre bien sagement la publication des resultats.☺</em>!<br>";
					while ($data = $vals->fetch())
					{
							echo '<img src="image/'.(stripslashes(htmlspecialchars($data['photo']))).'" width="50px" style="margin-bottom : 3px;"> &nbsp'.(stripslashes(htmlspecialchars($data['nom_cand']))).'<br>';
					}
				}
				else
				{
					while ($data = $vals->fetch()) 
					{		echo "<div class='row'>";
							echo '<img src="image/'.(stripslashes(htmlspecialchars($data['photo']))).'" width="60px" style="margin-bottom : 3px;"> &nbsp'.(stripslashes(htmlspecialchars($data['nom_cand']))).' <button class="btn btn-primary" data-toggle="modal" data-target="#comment'.(stripslashes(htmlspecialchars($data['id_cand']))).'"><i class="fas fa-check"></i> Voter</button><br></div>';
							echo '<div class="modal fade" id="comment'.(stripslashes(htmlspecialchars($data['id_cand']))).'">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
												<h4 class="modal-title">Confirmation</h4>
										</div>
										<div class="modal-body">
											Voulez-vous vraiment voter <br><img src="image/'.(stripslashes(htmlspecialchars($data['photo']))).'" width="50px" style="margin-bottom : 3px;"> &nbsp'.(stripslashes(htmlspecialchars($data['nom_cand']))).'
										</div>
										<div class="modal-footer">
												<a href="voter.php?id='.(stripslashes(htmlspecialchars($data['id_cand']))).'" class="btn btn-primary">Oui</a>
												<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
										</div>
									</div>
								</div>
							</div>
							';

					}
					echo '<div id="affichage"></div>';
				}
			}
		}
		else{
			while ($data = $vals->fetch())
			{
				echo '<img src="image/'.(stripslashes(htmlspecialchars($data['photo']))).'" width="50px" style="margin-bottom : 3px;"> &nbsp'.(stripslashes(htmlspecialchars($data['nom_cand']))).'<br>';
			}
			echo '<div id="affichage1"></div>';
		}
		
		
	?>
	<a href="terminer.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Terminer</a>

	
	
</body>
</html>