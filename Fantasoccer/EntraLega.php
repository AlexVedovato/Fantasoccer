<?php
    require_once('Fantacalcio.php');
    session_start();
    if(empty($_SESSION["id_fantallenatore"])){
        header("Location: ./SelezionaLega.php");die;
    }

    if (empty($_GET["id_fantalega"])) {  header("Location: ./SelezionaLega.php"); die;}
    
    $_SESSION["id_fantalega"]=$_GET["id_fantalega"];

    $_SESSION["amministratoreSN"]=Fantacalcio::getAmministratoreSN($_SESSION["id_fantallenatore"],$_SESSION["id_fantalega"]);
    header("Location: ./AreaFantallenatore.php");
?>