<?php
    session_start();
    require_once('Fantacalcio.php');

    if(empty($_SESSION["id_fantallenatore"])){
      header("Location: ./login.php");die;
    }
      if(empty($_SESSION["id_fantalega"])){
        header("Location: ./SelezionaLega.php");die;
    }

    if (empty($_POST["nome"])) {  header("Location: ./creaSquadra.php?error=1"); die;}
    if(Fantacalcio::checkFantasquadraEsistente($_POST["nome"], $_SESSION["id_fantalega"])){ header("Location: ./creaSquadra.php?error=2"); die;}
    
    if($_FILES["image"]["size"]==0){
      $image=NULL;
    } else {
        $arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
            header("Location: ./creaSquadra.php?error=4");die;
        }
        $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    }

  $id_fantasquadra=Fantacalcio::getNextIdFantasquadra();
  $result=Fantacalcio::creaSquadra($_POST["nome"],$id_fantasquadra,$image,$_SESSION["id_fantallenatore"],$_SESSION["id_fantalega"]);
  
  if($result){
    header("Location: ./AreaFantallenatore.php");
  } else {
    header("Location: ./creaSquadra.php?error=3");
  }

?>