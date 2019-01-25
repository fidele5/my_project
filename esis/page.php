<?php
	function getprom($prom)
	{
		 try 
	    {
	        $connexion = new PDO("mysql:host=localhost;dbname=electionesis", 'root', '');
	        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	    catch (Exception $e) 
	    {
	        die('Erreur : ' . $e->getMessage());
	    }

	    $res =  $connexion->prepare('SELECT * FROM candidat');
		$res->execute();
		while ($data = $res->fetch()) 
		{
		    	//echo $data['id_elec'].' : '.$data['matricule'].' '.$data['id_cand'].' '.$data['promotion'].'<br>';
		    	echo '<td>'. FunctionName($data['id_cand'], $prom).'</td>';
		}
	}
	function getcand()
	{
		 try 
	    {
	        $connexion = new PDO("mysql:host=localhost;dbname=electionesis", 'root', '');
	        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	    catch (Exception $e) 
	    {
	        die('Erreur : ' . $e->getMessage());
	    }

	    $res =  $connexion->prepare('SELECT * FROM candidat');
		$res->execute();
		while ($data = $res->fetch()) 
		{
		    	//echo $data['id_elec'].' : '.$data['matricule'].' '.$data['id_cand'].' '.$data['promotion'].'<br>';
		    	echo '<th scope="col">'. $data['nom_cand'].'</th>';
		}
	}

	function getotal()
	{
		 try 
	    {
	        $connexion = new PDO("mysql:host=localhost;dbname=electionesis", 'root', '');
	        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	    catch (Exception $e) 
	    {
	        die('Erreur : ' . $e->getMessage());
	    }

	    $res =  $connexion->prepare('SELECT * FROM candidat');
		$res->execute();
		while ($data = $res->fetch()) 
		{
		    	echo '<td scope="col">'. $data['nbre_voix'].'</td>';
		}
	}
   

    function FunctionName($id, $prom)
    {
    	try 
	    {
	        $connexion = new PDO("mysql:host=localhost;dbname=electionesis", 'root', '');
	        $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	    catch (Exception $e) 
	    {
	        die('Erreur : ' . $e->getMessage());
	    }
    	$res =  $connexion->prepare('SELECT COUNT(*) FROM electeurs INNER JOIN prom ON electeurs.id_elec = prom.id_electeur WHERE id_candidat = :id AND promotion = :prom');
    	$res->bindValue(':id', $id);
    	$res->bindValue(':prom', $prom);
	    $res->execute();
	    $data = $res->fetchColumn();
	    return $data;
    }
?>
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
    <!--// Fontawesome Css -->
    <section class="tables-section">
<div class="outer-w3-agile mt-3">
    <h4 class="tittle-w3-agileits mb-4">RESULTATS PAR PROMOTION</h4>
        <div class="container-fluid">
            <div class="row">
               <table class="table col-xl mr-xl-3">
                    <thead>
                        <tr>
                            <th scope="col">Class</th>
                            <?= getcand() ?>
                        </tr>
                    </thead>
                    
                    <tbody>
                    	<tr>
                    		<td>PREPARATOIRE</td>
                    		<?= getprom('PREPA') ?>
                    	</tr>
                        <tr>
                        	<td>G1</td>
                        	<?= getprom('G1') ?>
                        </tr>
                        <tr>
                        	<td>G2 SYSTEME INFO</td>
                        	<?= getprom('G2SI') ?>
                        </tr>
                        <tr>
                        	<td>G2 GESTION</td>
                        	<?= getprom('G2GEST') ?>
                        </tr>
                        <tr>
                        	<td>G2 DESIGN</td>
                        	<?= getprom('G2DSG') ?>
                        </tr>
                        <tr>
                        	<td>G2 A SYSTEME </td>
                        	<?= getprom('G2RES') ?>
                        </tr>
                        <tr>
                        	<td>G2 TELECOM</td>
                        	<?= getprom('G2TLC') ?>
                        </tr>
                        <tr>
                        	<td>G3 SYSTEME INFO</td>
                        	<?= getprom('G3SI') ?>
                        </tr>
                        <tr>
                        	<td>G3 GESTION</td>
                        	<?= getprom('G3GEST') ?>
                        </tr>
                        <tr>
                        	<td>G3 DESIGN</td>
                        	<?= getprom('G3DSG') ?>
                        </tr>
                        <tr>
                        	<td>G3 A SYSTEME </td>
                        	<?= getprom('G3RES') ?>
                        </tr>
                        <tr>
                        	<td>G3 TELECOM</td>
                        	<?= getprom('G3TLC') ?>
                        </tr>
                        <tr class="bg-success">
                        	<td>TOTAL</td>
                        	<?= getotal() ?>
                        </tr>
                     </tbody>
                </table>
            </div>
        </div>
</div>
<center>
	<a href="stats.php" class="btn btn-primary"><i class="fas fa-hand-point-left"></i> Retour</a>
</center>

</section>