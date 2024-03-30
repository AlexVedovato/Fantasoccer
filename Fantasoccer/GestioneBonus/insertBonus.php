<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (count($_POST)!=2) { header("Location: ./viewBonus.new.php?error=1"); die; }
if (empty($_POST["descrizione"])) {  header("Location: ./viewBonus.new.php?error=2"); die;}
if (empty($_POST["valore_default"])) {  header("Location: ./viewBonus.new.php?error=5"); die;}
if (Fantacalcio::checkBonusEsistente($_POST["descrizione"])) {  header("Location: ./viewBonus.new.php?error=4"); die;}

if($_FILES["image"]["size"]==0){
    $image=NULL;
} else {
    $arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
    if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
        header("Location: ./viewBonus.new.php?error=3");die;
    }
    $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
}
$result = Fantacalcio::inserisciBonus($_POST["descrizione"],$image,$_POST["valore_default"]);

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=1");
}
?>