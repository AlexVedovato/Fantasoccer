<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (empty($_POST["id_bonus"])) {  header("Location: ./index.php?error=5"); die;}
if (count($_POST)!=3) { header("Location: ./viewBonus.update.php?id_bonus=".$_POST["id_bonus"]."&error=1"); die; }
if (empty($_POST["descrizione"])) {  header("Location: ./viewBonus.update.php?id_bonus=".$_POST["id_bonus"]."&error=2"); die;}
if (empty($_POST["valore_default"])) {  header("Location: ./viewBonus.update.php?id_bonus=".$_POST["id_bonus"]."&error=5"); die;}
if($_POST["descrizione"]!=Fantacalcio::getBonus($_POST["id_bonus"])["descrizione"]){
    if (Fantacalcio::checkBonusEsistente($_POST["descrizione"])) {  header("Location: ./viewBonus.update.php?id_bonus=".$_POST["id_bonus"]."&error=4"); die;}
}

if(!empty($_FILES["image"])){
    if($_FILES["image"]["size"]==0){
        $image=NULL;
    } else {
        $arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
            header("Location: ./viewBonus.update.php?id_bonus=".$_POST["id_bonus"]."&error=3");die;
        }
        $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    }
    
    $result = Fantacalcio::modificaBonus($_POST["id_bonus"],$_POST["descrizione"],$image,$_POST["valore_default"]);
} else {
    
    $result = Fantacalcio::modificaBonusNoStemma($_POST["id_bonus"],$_POST["descrizione"],$_POST["valore_default"]);
}


if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=3");
}

?>