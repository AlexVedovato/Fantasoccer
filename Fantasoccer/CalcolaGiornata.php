<?php
    require_once('./Fantacalcio.php');
    session_start();
    if(empty($_SESSION["id_fantallenatore"])){
        header("Location: ./login.php");die;
    }
    if(empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])){
        header("Location: ./SelezionaLega.php");die;
    }
    if($_SESSION["amministratoreSN"]=='N'){
        header("Location: ./AreaFantallenatore.php");die;
    }
    if (empty($_GET["numero_giornata"])) {  header("Location: ./CalcolaGiornate.php?error=1"); die;}
    if(!Fantacalcio::isGiornataPassata($_GET["numero_giornata"])) {  header("Location: ./CalcolaGiornate.php?error=2"); die;}
    if($_GET["numero_giornata"]<Fantacalcio::getNumeroPrimaGiornata($_SESSION["id_fantalega"])) {  header("Location: ./CalcolaGiornate.php?error=3"); die;}
    if(Fantacalcio::isGiornataCalcolata($_GET["numero_giornata"],$_SESSION["id_fantalega"])) {  header("Location: ./CalcolaGiornate.php?error=4"); die;}

    $result=Fantacalcio::calcolaGiornata($_GET["numero_giornata"],$_SESSION["id_fantalega"]);

    if($result){
        header("Location: ./AreaFantallenatore.php");
      } else {
        header("Location: ./CalcolaGiornate.php?error=5");
      }

?>