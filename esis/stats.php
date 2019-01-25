<?php
	session_name('election');
	session_start();

	require_once('election.php');
	require_once 'bdd.php';

	$elect = new elections();
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  	<!-- Bootstrap Css -->
    <!-- Common Css -->
    <link href="css/style1.css" rel="stylesheet" type="text/css" media="all" />
    <!--// Common Css -->
    <!-- Nav Css -->
    <link rel="stylesheet" href="css/style4.css">
    <!--// Nav Css -->
    <!-- Fontawesome Css -->
    <link href="css/fontawesome-all.css" rel="stylesheet">

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!--// Fontawesome Css -->
</head>
<body>
	<div class='wrapper'>
		<div id="content">
			<nav id="sidebar"></nav>
			<center>
			<h2 class="main-title-w3layouts mb-2 text-center">Statistiques</h2>
			<div class="outer-w3-agile mb-4 text-center col-xl-7">
			<div class="stat-grid p-3 mt-3 d-flex align-items-center justify-content-between bg-success">
                <div class="s-l">
                    <h5>Participants</h5>
                </div>
                <div class="s-r">
                    <h6><?= $elect->getparticipants() ?>
                        <i class="far fa-smile"></i>
                    </h6>
                </div>
            </div>
			<div class="stat-grid p-3 d-flex align-items-center justify-content-between bg-primary">
                <div class="s-l">
                    <h5>Nombre d'electeurs</h5>
                </div>
                <div class="s-r">
                    <h6><?= $elect->getAllelecteurs() ?>
                        <i class="far fa-smile"></i>
                    </h6>
                </div>
            </div>
        </div>
<?php

	$max = (int)$elect->getAllelecteurs();
	
	echo '<h4 class="tittle-w3-agile mb-4">Resultats par candidat</h4>';
	$cands = $connexion->prepare('SELECT * FROM candidat ORDER BY nbre_voix DESC');
	$cands->execute();
	while ($data = $cands->fetch()) 
	{
		$valeur = (int)$elect->nbvoix($data['id_cand'])/(int)$elect->getAllelecteurs();
		$pourc = $valeur*100;
		echo'
		<div class="outer-w3-agile mb-4 text-center col-xl-7">
    <h4 class="tittle-w3-agileits mb-4">'.(stripcslashes(htmlspecialchars($data['nom_cand']))).'</h4>
        <ul class="percentg-circles-w3ls d-sm-flex justify-content-around">
            <li>
                <div class="chart circle-one">
                    <div class="figure">
                        <div class="pie"></div>
                    </div>
                    <div class="data-table">
                        <span class="percent">'.round($pourc).'%</span>
                    </div>

                </div>
            </li>
        </ul>
     <p>'.$elect->nbvoix(stripcslashes(htmlspecialchars($data['id_cand']))).' voix sur '.$elect->getAllelecteurs().'</p>
</div>
';
	}

	echo "<h3>Au final</h3>";
	$prezo = $connexion->prepare('SELECT MAX(nbre_voix), id_cand, nom_cand, nbre_voix FROM candidat ORDER BY nbre_voix DESC');
	$prezo->execute();
	$donnees = $prezo->fetch();
	$valeur = (int)$elect->nbvoix($donnees['id_cand'])/(int)$elect->getAllelecteurs();
	$valeurpourc = $valeur*100;
	echo 'le prezo est : '.(stripcslashes(htmlspecialchars($donnees['nom_cand']))).' avec '.(stripcslashes(htmlspecialchars($donnees['nbre_voix']))).'/'.$elect->getAllelecteurs()." soit ".round($valeurpourc)." % <br>";	
?>
    <!--// Style-sheets -->
    <a href="page.php" class="btn btn-primary"><i class="fas fa-table"></i> Resultats par promotion</a>
    <a href="terminer.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i>Terminer</a>
    </center>
	</div>
</div>
<!-- Required common Js -->
    <script src='js/jquery-2.2.3.min.js'></script>
    <!-- //Required common Js -->

    <!-- Sidebar-nav Js -->
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <!-- chart1 Js -->
    <script src="js/chart1.js"></script>
    <!--// chart1 Js -->

    <!--// percentage-circles Js -->
    <script src="js/percentage-circles.js"></script>
    <!--// percentage-circles Js -->

    <!-- Js for bootstrap working-->
    <script src="js/bootstrap.min1.js"></script>
    <!-- //Js for bootstrap working -->

</body>

</html>