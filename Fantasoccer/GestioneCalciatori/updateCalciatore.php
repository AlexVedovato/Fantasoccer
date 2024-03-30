<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (empty($_POST["id_calciatore"])) {  header("Location: ./index.php?error=5"); die;}
if (count($_POST)!=10) { header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=1"); die; }
if (empty($_POST["nome"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=2"); die;}
if (empty($_POST["cognome"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=3"); die;}
if (empty($_POST["ruolo"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=4"); die;}
if (empty($_POST["id_squadra_serieA"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=5"); die;}
if (empty($_POST["valore"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=6"); die;}
if (empty($_POST["infortunatoSCN"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=7"); die;}
if (empty($_POST["squalificatoSN"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=8"); die;}
if (empty($_POST["esteroSN"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=9"); die;}
if ($_POST["prob_giocare"]!=0 && empty($_POST["prob_giocare"])) {  header("Location: ./viewCalciatore.update.php?id_calciatore=".$_POST["id_calciatore"]."&error=10"); die;}


$result = Fantacalcio::modificaCalciatore($_POST["id_calciatore"],$_POST["nome"],$_POST["cognome"],$_POST["ruolo"],$_POST["id_squadra_serieA"],$_POST["valore"],$_POST["infortunatoSCN"],$_POST["squalificatoSN"],$_POST["esteroSN"],$_POST["prob_giocare"]);

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=3");
}
?>