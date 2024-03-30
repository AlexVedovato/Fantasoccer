<?php
require_once('./Fantacalcio.php');
session_start();
if (empty($_SESSION["id_fantallenatore"])) {
    header("Location: ./login.php");
    die;
}
if (empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])) {
    header("Location: ./SelezionaLega.php");
    die;
}
/*$fantasquadre = Fantacalcio::getSquadreFantalega($_SESSION["id_fantalega"]);
$idFantasquadre=array();
foreach($fantasquadre as $fantasquadra){
  array_push($idFantasquadre,$fantasquadra["id_fantasquadra"]);
}
if(!in_array($_GET["id_fantasquadra"],$idFantasquadre)){
  header("Location: ./AreaFantallenatore.php?error=15");die;
}*/

$calciatore = Fantacalcio::getCalciatore($_GET["id_calciatore"]);
$datiCalciatore = Fantacalcio::getDatiCalciatore($_GET["id_calciatore"], $_SESSION["id_fantalega"], $calciatore["ruolo"] == "Portiere");

?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/ViewDettaglioCalciatore.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>

</head>

<body>
    <?php
    include("./Navbar.php");
    ?>

    <table class="table-rounded">

        <tr>
            <th colspan="3"><?php
                            echo '<div class="row">

<div class="col">' . "Nome" . "</div>" . '
<div class="col">' . "Cognome" . "</div></div>"

                            ?>
            </th>
        </tr>
        <tr>
            <td align="center" colspan="3"><?php
                                            echo '<div class="row">
    <div class="col">
    <div class="col align-self-center">' . $calciatore["nome"] . "</div></div>" . '
    <div class="col align-self-center">' .  $calciatore["cognome"] . "</div>"; ?></td>
        </tr>

        

        <?php if($calciatore["ruolo"] == "Portiere") {
              if(count($datiCalciatore)==0){?>
                  <tr>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Goal" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Assist" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Rigori parati" . "</div>"; ?></td>
        </tr>
        <?php } else { ?>
        <tr>
            <td><?php echo ($datiCalciatore["goal"]) . '
      <div class="col sottotitoli">' . " Goal" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["assist"]) . '
      <div class="col sottotitoli">' . " Assist" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["rigori_parati"]) . '
      <div class="col sottotitoli">' . " Rigori parati" . "</div>"; ?></td>
        </tr>
        <?php }}else{ 
               if(count($datiCalciatore)==0){?>
                  <tr>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Goal" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Assist" . "</div>"; ?></td>
            <td><?php echo("0") . "/" . "0". ' 
      <div class="col sottotitoli">' . " Rigori segnati/tirati" . "</div>"; ?></td>
        </tr>
        <?php } else { ?>
            <td><?php echo ($datiCalciatore["goal"]) . '
      <div class="col sottotitoli">' . " Goal" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["assist"]) . '
      <div class="col sottotitoli">' . " Assist" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["goal_rigore"]) . '/' . $datiCalciatore["rigori_totali"] . '
      <div class="col sottotitoli">' . " Rigori segnati/tirati" . "</div>"; ?></td>
        </tr>
        <?php }} ?>
        

        <tr>
        <?php if(count($datiCalciatore)==0){?>
                  <tr>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Presenze" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Media voto" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Media fantavoto" . "</div>"; ?></td>
        </tr>
        <?php } else { ?>
            <td><?php echo ($datiCalciatore["numeroPrestazioni"]) . '
      <div class="col sottotitoli">' . " Presenze" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["media_voto"]) . '
      <div class="col sottotitoli">' . " Media voto" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["media_fantavoto"]) . '
      <div class="col sottotitoli">' . " Media fantavoto" . "</div>"; ?></td>
        </tr>
        <?php } ?>

        <tr>
        <?php if(count($datiCalciatore)==0){?>
                  <tr>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Autogol" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Ammonizioni" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Espulsioni" . "</div>"; ?></td>
        </tr>
        <?php } else { ?>
            <td><?php echo ($datiCalciatore["autogol"]) . '
      <div class="col sottotitoli">' . " Autogol" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["ammonizioni"]) . '
      <div class="col sottotitoli">' . " Ammonizioni" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["espulsioni"]) . '
      <div class="col sottotitoli">' . " Espulsioni" . "</div>"; ?></td>
        </tr>
        <?php } ?>

        <?php if($calciatore["ruolo"] == "Portiere") {
              if(count($datiCalciatore)==0){?>
                  <tr>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Goal subiti" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Rigori parati" . "</div>"; ?></td>
            <td><?php echo("0") . '
      <div class="col sottotitoli">' . " Porte inviolate" . "</div>"; ?></td>
        </tr>
        <?php } else { ?>
            <tr>
            <td><?php echo ($datiCalciatore["goal_subiti"]) . '
      <div class="col sottotitoli">' . " Goal subiti" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["rigori_parati"]) . '
      <div class="col sottotitoli">' . " Rigori parati" . "</div>"; ?></td>
            <td><?php echo ($datiCalciatore["portaInviolata"]) . '
      <div class="col sottotitoli">' . " Porte inviolate" . "</div>"; ?></td>
        </tr>
        <?php }} ?>
    </table>



</body>


</html>