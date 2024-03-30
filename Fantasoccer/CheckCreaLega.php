<?php
    session_start();
    require_once('Fantacalcio.php');

    if(empty($_SESSION["id_fantallenatore"])){
      header("Location: ./login.php");die;
    }

    if (empty($_POST["nome"])) {  header("Location: ./creaLega.php?error=1"); die;}
    if(Fantacalcio::checkFantalegaEsistente($_POST["nome"])){ header("Location: ./creaLega.php?error=17"); die;}
    if (empty($_POST["parola_ordine"])) {  header("Location: ./creaLega.php?error=2"); die;}
    if (empty($_POST["crediti_iniziali"])) {  header("Location: ./creaLega.php?error=3"); die;}
    if (empty($_POST["numero_portieri"])) {  header("Location: ./creaLega.php?error=4"); die;}
    if (empty($_POST["numero_difensori"])) {  header("Location: ./creaLega.php?error=5"); die;}
    if (empty($_POST["numero_centrocampisti"])) {  header("Location: ./creaLega.php?error=6"); die;}
    if (empty($_POST["numero_attaccanti"])) {  header("Location: ./creaLega.php?error=7"); die;}
    if (empty($_POST["voto_ammonito_sv"])) {  header("Location: ./creaLega.php?error=8"); die;}
    if (empty($_POST["tempo_termine_formazione"])) {  header("Location: ./creaLega.php?error=9"); die;}
    if (empty($_POST["punteggio_formazione_schierataN"])) {  header("Location: ./creaLega.php?error=10"); die;}
    if (empty($_POST["soglia_goal"])) {  header("Location: ./creaLega.php?error=11"); die;}
    if (empty($_POST["moduli"])) { header("Location: ./creaLega.php?error=12"); die;}
    if (count($_POST["valoriBonus"])!=Fantacalcio::getNumeroBonus()) { header("Location: ./creaLega.php?error=13"); die;}
    foreach($_POST["valoriBonus"] as $valoreBonus){
      if(empty($valoreBonus) && $valoreBonus==''){ header("Location: ./creaLega.php?error=13"); die;}
    }
    if (count($_POST["id_bonus"])!=Fantacalcio::getNumeroBonus()) { header("Location: ./creaLega.php?error=14"); die;}
    foreach($_POST["id_bonus"] as $id_bonus){
      if(empty($id_bonus)){ header("Location: ./creaLega.php?error=14"); die;}
    }
    
    if($_FILES["image"]["size"]==0){
      $image=NULL;
    } else {
        $arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
            header("Location: ./creaLega.php?error=15");die;
        }
        $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    }

  $id_fantalega=Fantacalcio::getNextIdFantalega();
  $result=Fantacalcio::creaLega($_POST["nome"],$image,$_POST["parola_ordine"],$id_fantalega,$_SESSION["id_fantallenatore"],$_POST["crediti_iniziali"],$_POST["soglia_goal"], $_POST["punteggio_formazione_schierataN"], $_POST["numero_attaccanti"], $_POST["numero_difensori"], $_POST["numero_centrocampisti"], $_POST["numero_portieri"], $_POST["tempo_termine_formazione"], $_POST["voto_ammonito_sv"],$_POST["moduli"],$_POST["valoriBonus"],$_POST["id_bonus"]);
  if($result){
    $_SESSION["id_fantalega"]=$id_fantalega;
    $_SESSION["amministratoreSN"]='S';
    header("Location: ./AreaFantallenatore.php");
  } else {
    header("Location: ./creaLega.php?error=16");
  }
  
?>