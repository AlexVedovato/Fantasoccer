<?php
require_once('Fantacalcio.php');
session_start();

if(empty($_SESSION["id_fantallenatore"])){
  header("Location: ./login.php");die;
}
if(empty($_GET["id_fantalega"])){
  header("Location: ./UniscitiLega.php");die;
}

if(Fantacalcio::isCompetizioneAvviata($_GET["id_fantalega"])){
    header("Location: ./UniscitiLega.php?error=1");die;
} else {
    if(Fantacalcio::inserisciFantallenatoreFantalega('N',$_GET["id_fantalega"],$_SESSION["id_fantallenatore"])){
        $_SESSION["id_fantalega"]=$_GET["id_fantalega"];
        $_SESSION["amministratoreSN"]='N';
        header("Location: ./AreaFantallenatore.php");die;
    } else {
        header("Location: ./UniscitiLega.php?error=2");die;
    }
}
?>