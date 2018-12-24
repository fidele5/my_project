<?php
	require_once 'header.php';
?>
	<div class="section">
			<!-- container -->
			<div class="container">
				 <div class="outer-w3-agile col-xl mt-3 mx-xl-3 p-xl-0 px-md-5">
						<div class="container wrap">
						    <div class="row">
						        <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
						            <div class="well well-sm">
						                <div class="row">
						                    <div class="col-sm-4 col-md-6 col-lg-7">
						                        <img src="fichier/<?= $data['membre_avatar']?>" alt="" class="img-rounded img-responsive" />
						                    </div>
						                    <div class="col-sm-8 col-md-6 col-lg-5">
						                        <h4><?= $data['membre_pseudo']?></h4>
						                        <small><cite title="San Diego, USA">San Diego, USA <i class="fa fa-map-marker"></i></cite></small>
						                        <p>
						                            <i class="glyphicon glyphicon-envelope"></i><a href="mailto:<?= $data['membre_email']?>"><?= $data['membre_email']?></a>
						                            <br />
						                            <i class="fa fa-globe"></i><a href="https://bashamalexcom.000webhostapp.com/">Bashamalex.com</a>
						                            <br />
						                            <i class="fa fa-phone"></i>+243 974 217 408<br>
						                            <i class="fa fa-gear"></i><a href=""> Modifier profil</a>
						                        </p>
						                        <div class="btn-group">
						                            <a href="https://facebook.com/bashamalex" class="btn btn-primary"><span class="fa fa-2x fa-facebook"></span></a>
						                            <a href="mailto:fidelepl@gmail.com" class="btn btn-danger"><span class="fa fa-2x fa-google"></span></a>
						                            <a href="@fideleplk" class="btn btn-primary""><span class="fa fa-2x fa-twitter"></span></a>
						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
					    	</div>
						</div>
				</div>
			</div>
<?php
	require_once 'footer.php';
?>
