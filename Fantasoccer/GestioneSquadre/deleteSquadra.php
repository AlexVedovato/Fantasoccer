<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (count($_GET)!=1) { header("Location: ./index.php?error=4"); die; }
if (empty($_GET["id_squadra_serieA"])) {  header("Location: ./index.php?error=4"); die;}

$result=Fantacalcio::eliminaSquadra($_GET["id_squadra_serieA"]);

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=4");
}
?>