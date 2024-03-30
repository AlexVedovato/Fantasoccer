<?php
require_once('../Fantacalcio.php');
session_start();

if (empty($_SESSION["id_admin"])) {
    header("Location: ../login.php?type=Admin");
    die;
}

    if (count($_POST)!=2) { header("Location: ./viewPagellista.new.php?error=1"); die; }
    if (empty($_POST["username"])) {  header("Location: ./viewPagellista.new.php?error=2"); die;}
    if (empty($_POST["password"])) {  header("Location: ./viewPagellista.new.php?error=3"); die;}
    if (Fantacalcio::checkPagellistaEsistente($_POST["username"])) {  header("Location: ./viewPagellista.new.php?error=4"); die;}

    
    $result = Fantacalcio::inserisciPagellista($_POST["username"],$_POST["password"]);

    if($result){
        header("Location: ./index.php");
    } else {
        header("Location: ./index.php?error=1");
    }

?>