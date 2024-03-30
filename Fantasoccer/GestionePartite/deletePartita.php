<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (count($_GET)!=3) { header("Location: ./index.php?error=4"); die; }
if (empty($_GET["numero_giornata"]) && empty($_GET["id_squadra_serieA_casa"]) && empty($_GET["id_squadra_serieA_trasferta"]))
 {  header("Location: ./index.php?error=4"); die;}

$result=Fantacalcio::eliminaPartitaSerieA($_GET["numero_giornata"],$_GET["id_squadra_serieA_casa"],$_GET["id_squadra_serieA_trasferta"]);

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=4");
}

?>