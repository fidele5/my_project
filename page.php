<?php
	require_once 'header.php';
?>
	<div class="section">
			<!-- container -->
			<div class="container">
				<div style="width: 80%" class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
					<h4 class="text-center">Les Actus</h4>
						<div id="messages">
							<?php
								$select = $connexion->prepare('SELECT * FROM actus INNER JOIN espace ON espace.membre_id = actus.id_auteur ORDER BY id_actu DESC');
								$select->execute();
								$message = null;
								while ($donnees=$select->fetch()) {
									$message.= "<p id=\"" . $donnees['id_actu'] . "\" style='padding : 8px; width : 80%; border-bottom : 1px solid silver; margin-bottom : 5px;'><table>
												<tr>
													<td><div id='img'><img src='fichier/".$donnees['membre_avatar']."' id='icon'/></div></td>
													<td> <div id='contenu'><span style='color : #009688;' >".$donnees['titre_actu']."</span><br>".$donnees['text_actu'].'<br> Publié le : '.$donnees['date_post']."<br> par : <a href=''>".$donnees['membre_pseudo']."</a></div></td>
												</tr>
											</table>
											</p>";
								}	
								echo $message;
							?>
						</div>
	                    <form action="traiter.php" method="post">
	                    	<h4>Publier quelque chose</h4>
							<div class="row">
								<div class="form-group">
                                    <div class="col-xs-8" style="border-radius: 5px; border : 1px solid yellowgreen; padding: 3px; margin-bottom: 3px; width: 50%; margin-left: 12px">
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-italic"></i><span class="tooltipp"></span></a></button>
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-bold"></i><span class="tooltipp"></span></a></button>
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-underline"></i><span class="tooltipp"></span></a></button>
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-align-left"></i><span class="tooltipp"></span></a></button>
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-align-center"></i><span class="tooltipp"></span></a></button>
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-align-right"></i><span class="tooltipp"></span></a></button>
									<button id="but"><a href="" class="cta-btn"><i class="fa fa-align-justify"></i><span class="tooltipp"></span></a></button>
									<input type="file" name="file" id="input">
								</div>          
                                </div>
                                	<div class="col-xs-8">
				                        <input type="text" name="titre" id="titre" class="form-control pb-chat-text" placeholder="entrer le titre ...">
				                    </div>
				                    <div class="col-xs-8">
				                        <textarea class="form-control pb-chat-textarea" placeholder="Entrer l'actu ..." name="texte" id="texte"></textarea>
				                        <input type="hidden" name="id" id="id" value="<?= $_SESSION['id'] ?>">
				                    </div>
				                    <div class="col-xs-2 pb-btn-circle-div">
				                        <button class="btn btn-primary btn-circle pb-chat-btn-circle" id="send"><span class="fa fa-chevron-right"></span></button>
				                    </div>
							</div>
						</form>
			</div>
	</div>
		<script type="text/javascript">
		$(document).ready(function ()
		{
		    $('#send').click(function(e) 
		    {
		        e.preventDefault();
		        t = $(this);
		        var titre = $('#titre').val();
		        var texte = $('#texte').val();
		        var id = $('#id').val();
		        t.after("<br><span id='send_status'>Envoi en cours .....</span>");
		           $.post(
		            'traiter.php', 
		            {
		              titre : $('#titre').val(),
		              texte : $('#texte').val(),
		              id : $('#id').val(),
		            },  
		          function (data)
		           {
			            if (data == 'Ok') 
			            {
			            	$("#send_status").remove();
			            	alert('Commentaire ajouté');
			            	t[0].reset();
			            }
			            else{
			            	alert('Commentaire non ajouté');
			            	$("#send_status").remove();
			            }
		            }
		          );
		        return false;
		    });
		});
	</script>
<script type="text/javascript">
	function charger()
	{
	setTimeout( function()
	{
		// on lance une requête AJAX
		var premierID = $('#messages p:first').attr('id');
		$.ajax({
			url : "chargement.php?f=" + premierID, // on passe l'id le plus récent au fichier de chargement
			type : "GET",
			success : function(html)
			{
				$('#messages').prepend(html);
			}
		});
		charger();
	}, 5000);
}
charger();// on exécute le chargement toutes les 5 secondes
</script>
<?php
	require_once 'footer.php';
?>
