<?php
require_once('Fantacalcio.php');
session_start();

if (empty($_SESSION["id_fantallenatore"])) {
    header("Location: ./login.php");
    die;
}
if (empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])) {
    header("Location: ./SelezionaLega.php");
    die;
}
if ($_SESSION["amministratoreSN"] == 'N') {
    header("Location: ./AreaFantallenatore.php");
    die;
}

if (count($_POST)!=3) { header("Location: ./SvincolaCalciatore.php?error=1"); die; }
if (empty($_POST["id_calciatore"])) {  header("Location: ./SvincolaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=2"); die;}
if (empty($_POST["id_fantasquadra"])) {  header("Location: ./SvincolaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=3"); die;}
if (empty($_POST["costo_acquisto"])) {  header("Location: ./SvincolaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=4"); die;}


$result=Fantacalcio::svincolaCalciatore($_POST["id_calciatore"], $_POST["id_fantasquadra"], $_POST["costo_acquisto"]);

if($result){

    header("Location: ./SvincolaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]);
} else {
    header("Location: ./SvincolaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=1");
}
?>