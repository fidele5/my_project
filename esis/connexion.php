<?php
    //require_once('bdd.php');
    session_name('election');
    session_start();
    require_once('election.php');

    $elec = new elections();
    if (isset($_SESSION['erreurs'])) {
        $err1  = $_SESSION['erreur1'];
        $err2  = $_SESSION['erreur2'];
        $err3  = $_SESSION['erreur3'];
        $err4  = $_SESSION['erreur4']; 
        $mat   = $_SESSION['matricule'];
        $pwd   = $_SESSION['pwd'];
        $prom  = $_SESSION['prom'];
    }
    else{
        $err1 = null;
        $err2 = null;
        $err3 = null;
        $err4 = null;
        $mat  = null;
        $pwd  = null;
        $prom = null;
    }

?>
<style type="text/css">
    em{
        color: red;
    }
</style>
<h1>Connectez vous</h1>
<?= $err4?>
<form action="compile.php" method="post" >
    <input type="text" name="mat" id="mat" placeholder="Votre matricule" value="<?= $mat?>"><br>
    <?php echo $err1 ?>
    <input type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" value="<?= $pwd?>"><br>
    <?php echo $err2; ?>
    <select name="prom">
        <option value="PREPA">PREPARATOIRE</option>
        <option value="G1">PREMIER GRADUAT</option>
        <optgroup label="GENIE LOGICIEL">
            <option value="G2SI">G2 SYSTEME INFO</option>
            <option value="G2GEST">G2 GESTION</option>
            <option value="G3SI">G3 SYSTEME INFO</option>
            <option value="G3GEST">G3 GESTION</option>
        </optgroup>
        <optgroup label="DESIGN">
            <option value="G2DSG">G2 DESIGN</option>
            <option value="G3DSG">G3 DESIGN</option>
        </optgroup>
        <optgroup label="RESEAUX ET TELECOM">
            <option value="G2RES">G2 RESEAUX</option>
            <option value="G2TLC">G2 TELECOM</option>
            <option value="G3RES">G3 RESEAUX</option>
            <option value="G3TLC">G3 TELECOM</option>
        </optgroup>
    </select><br>
    <?php echo $err3; ?>
    <input type="submit" value="Connexion">
</form>
<script type="text/javascript" src="compte.js"></script>
<div id="affichage"></div>