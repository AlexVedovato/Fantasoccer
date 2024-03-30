<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (count($_POST)!=1) { header("Location: ./viewSquadra.new.php?error=1"); die; }
if (empty($_POST["nome"])) {  header("Location: ./viewSquadra.new.php?error=2"); die;}
if (Fantacalcio::checkSquadraEsistente($_POST["nome"])) {  header("Location: ./viewSquadra.new.php?error=4"); die;}

if($_FILES["image"]["size"]==0){
    $image=NULL;
} else {
    $arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
    if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
        header("Location: ./viewSquadra.new.php?error=3");die;
    }
    $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
}

$result = Fantacalcio::inserisciSquadra($_POST["nome"],$image);

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=1");
}
?>