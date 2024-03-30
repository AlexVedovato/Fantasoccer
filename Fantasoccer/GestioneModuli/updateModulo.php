<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (empty($_POST["id_modulo"])) {  header("Location: ./index.php?error=7"); die;}
if (count($_POST)!=4) { header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=1"); die; }
if (empty($_POST["numeroDifensori"])) {  header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=2"); die;}
if (empty($_POST["numeroCentrocampisti"])) {  header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=3"); die;}
if (empty($_POST["numeroAttaccanti"])) {  header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=4"); die;}
if (($_POST["numeroDifensori"]+$_POST["numeroCentrocampisti"]+$_POST["numeroAttaccanti"]>10)) {  header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=5"); die;}
if (($_POST["numeroDifensori"]+$_POST["numeroCentrocampisti"]+$_POST["numeroAttaccanti"]<10)) {  header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=6"); die;}

if($_POST["numeroDifensori"]!=Fantacalcio::getModulo($_POST["id_modulo"])["numero_difensori"] || $_POST["numeroCentrocampisti"]!=Fantacalcio::getModulo($_POST["id_modulo"])["numero_centrocampisti"] || $_POST["numeroAttaccanti"]!=Fantacalcio::getModulo($_POST["id_modulo"])["numero_attaccanti"]){
    if (Fantacalcio::checkModuloEsistente($_POST["numeroDifensori"],$_POST["numeroCentrocampisti"],$_POST["numeroAttaccanti"])) {  header("Location: ./viewModulo.update.php?id_modulo=".$_POST["id_modulo"]."&error=8"); die;}
}

$result = Fantacalcio::modificaModulo($_POST["id_modulo"],$_POST["numeroDifensori"],$_POST["numeroCentrocampisti"],$_POST["numeroAttaccanti"]);

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=3");
}
?>