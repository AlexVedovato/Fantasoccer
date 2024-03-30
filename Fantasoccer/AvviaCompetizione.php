<?php
require_once('./Fantacalcio.php');
session_start();
if(empty($_SESSION["id_fantallenatore"])){
    header("Location: ./login.php");die;
}
if(empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])){
    header("Location: ./SelezionaLega.php");die;
}
if($_SESSION["amministratoreSN"]=='N'){
    header("Location: ./AreaFantallenatore.php");die;
}
$result=Fantacalcio::avviaCompetizione($_SESSION["id_fantalega"]);

if($result){
  header("Location: ./Calendario.php");
} else {
  header("Location: ./Calendario.php?error=1");
}
?>