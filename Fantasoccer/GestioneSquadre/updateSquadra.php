<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (empty($_POST["id_squadra_serieA"])) {  header("Location: ./index.php?error=5"); die;}
if (count($_POST)!=2) { header("Location: ./viewSquadra.update.php?id_squadra_serieA=".$_POST["id_squadra_serieA"]."&error=1"); die; }
if (empty($_POST["nome"])) {  header("Location: ./viewCalciatore.update.php?id_squadra_serieA=".$_POST["id_squadra_serieA"]."&error=2"); die;}
if($_POST["nome"]!=Fantacalcio::getNomeStemmaSquadra($_POST["id_squadra_serieA"])["nome"]){
    if (Fantacalcio::checkSquadraEsistente($_POST["nome"])) {  header("Location: ./viewSquadra.update.php?id_squadra_serieA=".$_POST["id_squadra_serieA"]."&error=4"); die;}
}

if(!empty($_FILES["image"])){
    if($_FILES["image"]["size"]==0){
        $image=NULL;
    } else {
        $arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
            header("Location: ./viewSquadra.update.php?error=3");die;
        }
        $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    }
    $result = Fantacalcio::modificaSquadra($_POST["id_squadra_serieA"],$_POST["nome"],$image);
} else {
    $result = Fantacalcio::modificaSquadraNoStemma($_POST["id_squadra_serieA"],$_POST["nome"]);
}


if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=3");
}
?>