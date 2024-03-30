<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if(empty($_POST["numero_giornata"]) || empty($_POST["id_squadra_serieA_casa"]) || empty($_POST["id_squadra_serieA_trasferta"])){header("Location: ./index.php?error=5"); die;}
if (count($_POST)!=5) { header("Location: ./viewPartita.update.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_serieA_casa=".$_POST["id_squadra_serieA_casa"]."&id_squadra_serieA_trasferta='".$_POST["id_squadra_serieA_trasferta"]."&error=1"); die; }
if (empty($_POST["rinviata"])) {  header("Location: ./viewPartita.update.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_serieA_casa=".$_POST["id_squadra_serieA_casa"]."&id_squadra_serieA_trasferta='".$_POST["id_squadra_serieA_trasferta"]."&error=4"); die;}


$result = Fantacalcio::modificaPartitaSerieA(empty($_POST["dataOraInizio"])?NULL:$_POST["dataOraInizio"],$_POST["numero_giornata"],$_POST["rinviata"],$_POST["id_squadra_serieA_casa"],$_POST["id_squadra_serieA_trasferta"]);


if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=3");
}
?>