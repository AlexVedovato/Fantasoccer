<?php
require_once('../Fantacalcio.php');
session_start();

if (empty($_SESSION["id_admin"])) {
    header("Location: ../login.php?type=Admin");
    die;
}

    if (count($_POST)!=5) { header("Location: ./viewPartita.new.php?error=1"); die; }
    if (empty($_POST["numeroGiornata"])) {  header("Location: ./viewPartita.new.php?error=3"); die;}
    if (empty($_POST["rinviata"])) {  header("Location: ./viewPartita.new.php?error=4"); die;}
    if (empty($_POST["id_squadra_serieA_casa"])) {  header("Location: ./viewPartita.new.php?error=5"); die;}
    if (empty($_POST["id_squadra_serieA_ospite"])) {  header("Location: ./viewPartita.new.php?error=6"); die;}

    if($_POST["id_squadra_serieA_casa"] == $_POST["id_squadra_serieA_ospite"]) {
        header("Location: ./viewPartita.new.php?error=7"); die;
    }

    if(Fantacalcio::isAlreadyUsed($_POST["id_squadra_serieA_casa"], $_POST["numeroGiornata"])) {
        header("Location: ./viewPartita.new.php?error=8"); die;
    }

    if(Fantacalcio::isAlreadyUsed($_POST["id_squadra_serieA_ospite"], $_POST["numeroGiornata"])) {
        header("Location: ./viewPartita.new.php?error=9"); die;
    }

    
    $result = Fantacalcio::inserisciPartitaSerieA(empty($_POST["dataOraInizio"])?NULL:$_POST["dataOraInizio"],$_POST["numeroGiornata"],$_POST["rinviata"],$_POST["id_squadra_serieA_casa"],$_POST["id_squadra_serieA_ospite"]);

    if($result){
        header("Location: ./index.php");
    } else {
        header("Location: ./index.php?error=1");
    }

?>