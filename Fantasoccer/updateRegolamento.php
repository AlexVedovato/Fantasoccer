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
    header("Location: ./Regolamento.php?error=1");die;
}

if (empty($_POST["id_fantalega"])) {  header("Location: ./Regolamento.php?error=2"); die;}
if (empty($_POST["crediti_iniziali"])) {  header("Location: ./Regolamento.php?error=3"); die;}
if (empty($_POST["numero_portieri"])) {  header("Location: ./Regolamento.php?error=4"); die;}
if (empty($_POST["numero_difensori"])) {  header("Location: ./Regolamento.php?error=5"); die;}
if (empty($_POST["numero_centrocampisti"])) {  header("Location: ./Regolamento.php?error=6"); die;}
if (empty($_POST["numero_attaccanti"])) {  header("Location: ./Regolamento.php?error=7"); die;}
if (empty($_POST["voto_ammonito_sv"])) {  header("Location: ./Regolamento.php?error=8"); die;}
if (empty($_POST["tempo_termine_formazione"])) {  header("Location: ./Regolamento.php?error=9"); die;}
if (empty($_POST["punteggio_formazione_schierataN"])) {  header("Location: ./Regolamento.php?error=10"); die;}
if (empty($_POST["soglia_goal"])) {  header("Location: ./Regolamento.php?error=11"); die;}
if (empty($_POST["moduli"])) { header("Location: ./Regolamento.php?error=12"); die;}
if (count($_POST["valoriBonus"])!=Fantacalcio::getNumeroBonus()) { header("Location: ./Regolamento.php?error=13"); die;}
foreach($_POST["valoriBonus"] as $valoreBonus){
    if(empty($valoreBonus) && $valoreBonus==''){ header("Location: ./Regolamento.php?error=13"); die;}
}
if (count($_POST["id_bonus"])!=Fantacalcio::getNumeroBonus()) { header("Location: ./Regolamento.php?error=14"); die;}
foreach($_POST["id_bonus"] as $id_bonus){
    if(empty($id_bonus)){ header("Location: ./Regolamento.php?error=14"); die;}
}


$result=Fantacalcio::updateRegolamento($_POST["id_fantalega"],$_POST["crediti_iniziali"],$_POST["soglia_goal"], $_POST["punteggio_formazione_schierataN"], $_POST["numero_attaccanti"], $_POST["numero_difensori"], $_POST["numero_centrocampisti"], $_POST["numero_portieri"], $_POST["tempo_termine_formazione"], $_POST["voto_ammonito_sv"],$_POST["moduli"],$_POST["valoriBonus"],$_POST["id_bonus"]);
  if($result){
    header("Location: ./Regolamento.php");
  } else {
    header("Location: ./Regolamento.php?error=15");
  }
?>