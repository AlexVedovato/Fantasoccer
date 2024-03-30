<?php
    session_start();
    require_once('Fantacalcio.php');

    if(empty($_SESSION["id_fantallenatore"])){
      header("Location: ./login.php");die;
    }
      if(empty($_SESSION["id_fantalega"])){
        header("Location: ./SelezionaLega.php");die;
    }
    $id_fantasquadra = Fantacalcio::getFantaquadra($_SESSION["id_fantallenatore"], $_SESSION["id_fantalega"])["id_fantasquadra"];
    if(empty($_POST["id_modulo"])){
      header("Location: ./AreaFantallenatore.php?error=7");die;
    }
    if(empty($_POST["numero_giornata"])){
      header("Location: ./AreaFantallenatore.php?error=8");die;
    }
    if(Fantacalcio::isFormazioneInserita($id_fantasquadra,$_POST["numero_giornata"])){
      header("Location: ./AreaFantallenatore.php?error=14");die;
    }
    if(Fantacalcio::isGiornataInCorso($_POST["numero_giornata"]) || Fantacalcio::isGiornataPassata($_POST["numero_giornata"])){
      header("Location: ./AreaFantallenatore.php?error=9");die;
    }
    if((count($_POST["portieri"])+count($_POST["difensori"])+count($_POST["centrocampisti"])+count($_POST["attaccanti"]))!=21){
      header("Location: ./AreaFantallenatore.php?error=10");die;
    }
    $idModuliConsentiti=Fantacalcio::getIdModuliConsentiti($_SESSION["id_fantalega"]);
    if(!in_array($_POST["id_modulo"],$idModuliConsentiti)){
      header("Location: ./AreaFantallenatore.php?error=11");die;
    }
    $calciatoriFantasquadra=Fantacalcio::getCalciatoriFantasquadra($id_fantasquadra);
    $idCalciatoriFantasquadra=array();
    foreach($calciatoriFantasquadra as $calciatoreFantasquadra){
      array_push($idCalciatoriFantasquadra,$calciatoreFantasquadra["id_calciatore"]);
    }
    foreach($_POST["portieri"] as $portiere){
      if(!in_array($portiere,$idCalciatoriFantasquadra)){
        header("Location: ./AreaFantallenatore.php?error=12");die;
      }
    }
    foreach($_POST["difensori"] as $difensore){
      if(!in_array($difensore,$idCalciatoriFantasquadra)){
        header("Location: ./AreaFantallenatore.php?error=12");die;
      }
    }
    foreach($_POST["centrocampisti"] as $centrocampista){
      if(!in_array($centrocampista,$idCalciatoriFantasquadra)){
        header("Location: ./AreaFantallenatore.php?error=12");die;
      }
    }
    foreach($_POST["attaccanti"] as $attaccante){
      if(!in_array($attaccante,$idCalciatoriFantasquadra)){
        header("Location: ./AreaFantallenatore.php?error=12");die;
      }
    }

    $result=Fantacalcio::inserisciFormazione($id_fantasquadra,$_POST["numero_giornata"],$_POST["id_modulo"],$_POST["portieri"],$_POST["difensori"],$_POST["centrocampisti"],$_POST["attaccanti"]);
    
  if($result){
    header("Location: ./AreaFantallenatore.php");
  } else {
    header("Location: ./AreaFantallenatore.php?error=13");
  }

?>