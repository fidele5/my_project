<?php 
	session_start();
	$bd_nom_serveur='localhost';
	$bd_login='id7387146_fidele';
	$bd_mot_de_passe='188085296'; 
	$bd_nom_bd='id7387146_plk2';
	try  
	{
		$connexion = new PDO("mysql:host=$bd_nom_serveur;dbname=$bd_nom_bd", $bd_login, $bd_mot_de_passe);
		$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e) 
	{
		die('Erreur : ' . $e->getMessage());
	}
?>
<!DOCTYPE html> 
<html lang="en"> 
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>VideosLib</title>

		<!-- Google font -->
		<link rel="shortcut icon" type="image/x-icon" href="img/icon.png" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i>(+243) 974 411 565</a></li>
						<li><a href="mailto:trudonfilsmulume@gmail.com"><i class="fa fa-envelope-o"></i>trudonfilsmulume@gmail.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1 Lubumbashi </a></li>
					</ul>
					<ul class="header-links pull-right">
						<?php
						if (isset($_SESSION['pseudo'])!='' && $_SESSION['rang'] == 2)
						{
							echo "<li><a href='admin/index.php'> Admin </a></li>";
						}
						elseif (isset($_SESSION['pseudo'])!='' && $_SESSION['rang'] == 1) {
							echo "<li><a href='profil/profil.php'><i class='fa fa-user-o'></i> ".htmlspecialchars($_SESSION['pseudo'])."</a></li>";
						}
						else{
							echo "<li><a href='sign_in/index.php'> S'inscrire </a></li>";
							echo "<li><a href='Login_v15/index.php'>Connexion</a></li>";
						} 
							
					 ?>
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.php" class="logo">
									<img src="./img/logo.jpg" alt="" width="120px">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form method="post" action="rechercher.php">
									<select class="input-select" name="selection">
										<option >Videos</option>
										<option >Livres</option>
										<option >Mp3</option>
									</select>
									<input class="input" placeholder="Search here" name="search">
									<button class="search-btn">Chercher</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="index.php"><i class="fa fa-home"></i>Accueil</a></li>
						<li><a href="livres/indexlivre.php"><i class="fa fa-book"></i> Livres</a></li>
						<li><a href="videos/indexvideo.php"><i class="fa fa-file-video-o"></i> Videos</a></li>
						<li><a href="mp3/indexmp3.php"><i class="fa fa-file-audio-o"></i> Mp3</a></li>
						<li><a href="videos/contact.php"><i class="fa fa-contact"></i> Contact</a></li>
						<li><a href="livres/tfc.php?categorie=tfc"><i class="fa fa-book"></i> Tfc</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- shop -->
					<?php
						$requete=$connexion->prepare("SELECT id_video, nom_video, avatar_video, v_nom, auteur_video, genre_video FROM fichiers LIMIT 0,3");
						$requete->execute();
						while ($data=$requete->fetch()) {
							echo '
							<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="admin/fichiers/'.(stripslashes(htmlspecialchars($data["avatar_video"]))).'" alt="">
							</div>
							<div class="shop-body">
								<h3>'.(stripslashes(htmlspecialchars($data["nom_video"]))).'</h3>
								<a href="videos/single.php?f='.(stripslashes(htmlspecialchars($data["id_video"]))).'&genre='.$data['genre_video'].'" class="cta-btn">Voir la video <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>';
						}
					?>
					<!-- /shop -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Nouveautés Mp3</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="videos/indexvideo.php">Videos</a></li>
									<li><a data-toggle="tab" href="livres/indexlivre.php">Livres</a></li>
									<li><a data-toggle="tab" href="mp3/indexmp3.php">Mp3</a></li>
									<li><a href="livres/tfc.php?categorie=tfc"><i class="fa fa-book"></i> Tfc</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
										<?php 
												$requete=$connexion->prepare("SELECT id_audio, nom_audio, v_nom, auteur_audio, genre_audio, prix FROM audio ORDER BY id_audio DESC LIMIT 0,6");
												$requete->execute();
												while ($data=$requete->fetch()) {
													echo '
											<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="img/product02.png" alt="">
												<div class="product-label">
													<span class="new">Nouveauté</span> 
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Mp3</p>
												<h3 class="product-name"><a href="#">'.(stripslashes(htmlspecialchars($data['nom_audio']))).'</a></h3>
												<h4 class="product-price">$'.(stripcslashes(htmlspecialchars($data['prix']))).'</h4>
												<div class="product-btns">
													<a href="mp3/single.php?f='.(stripslashes(htmlspecialchars($data["id_audio"]))).'&genre='.(stripcslashes(htmlspecialchars($data['genre_audio']))).'" class="cta-btn"><i class="fa fa-play"></i><span class="tooltipp">Ecouter</span></a>
												</div>
											</div>
										</div>';
												}
												?>
									</div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
		<!-- /HOT DEAL SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Nouveautés Livres</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="livres/index.php">Livres</a></li>
									<li><a data-toggle="tab" href="videos/index.php">Videos</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
										<?php
											$ex=$connexion->prepare("SELECT  livre_id, nom_Livre, date_upload, genre_livre, auteur_livre, prix, avatar_livre FROM livres ORDER BY livre_id DESC LIMIT 0,6");
											$ex->execute();
											while ($donnees=$ex->fetch()) {
												echo '
											<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="admin/livres/'.$donnees['avatar_livre'].'" alt="">
												<div class="product-label">
													<span class="new">Nouveauté</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Livre</p>
												<h3 class="product-name"><a href="#">'.$donnees["nom_Livre"].'</a></h3>
												<h4 class="product-price">$'.$donnees["prix"].'</h4>
												<div class="product-btns">
												<a href="livres/singlepage.php?f='.(stripslashes(htmlspecialchars($donnees["livre_id"]))).'" class="cta-btn">
													<button class="quick-view" style="background : royalblue; border-radius : 4px; border : 1px solid royalblue;"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button></a>
												</div>
											</div>
										</div>';
											}
											$ex->CloseCursor();
										?>
									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Inscrivez vous pour <strong>recevoir les notifications</strong></p>
								<a href="sign_in/index.php"> <button style="width: 160px; height: 40px; font-weight: 700; background: royalblue; color: #FFF; border: none; border-radius: 40px;"><i class="fa fa-envelope"></i>Souscrire </button></a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /NEWSLETTER -->

		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">A propos de nous</h3>
								<p>Nous vous fournissons les services de qualité pour votre service.</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>Lubumbashi</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>(+243) 974 411 565</a></li>
									<li><a href="mailto:trudonfilsmulume@gmail.com"><i class="fa fa-envelope-o"></i>trudonfilsmulume@gmail.com</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
									<li><a href="videos/indexvideo.php">Videos</a></li>
									<li><a href="livres/indexlivre.php">Livres</a></li>
									<li><a href="mp3/indexmp3.php">Mp3</a></li>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Informations</h3>
								<ul class="footer-links">
									<li><a href="videos/contact.php">Contactez nous</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Services</h3>
								<ul class="footer-links">
									<li><a href="Login_v15/index.php">Mon compte</a></li>
									<li><a href="admin/errorpage.html">Aide</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> Tous droits reservés <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="mailto:fideleplk@gmail.com" target="_blank">M@estro</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>
