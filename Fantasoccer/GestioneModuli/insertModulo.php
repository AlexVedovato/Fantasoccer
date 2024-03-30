<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
    header("Location: ../login.php?type=Admin");die;
 }

 if (count($_POST)!=3) { header("Location: ./viewModulo.new.php?error=1"); die; }
 if (empty($_POST["numeroDifensori"])) {  header("Location: ./viewModulo.new.php?error=2"); die;}
 if (empty($_POST["numeroCentrocampisti"])) {  header("Location: ./viewModulo.new.php?error=3"); die;}
 if (empty($_POST["numeroAttaccanti"])) {  header("Location: ./viewModulo.new.php?error=4"); die;}
 if (($_POST["numeroDifensori"]+$_POST["numeroCentrocampisti"]+$_POST["numeroAttaccanti"]>10)) {  header("Location: ./viewModulo.new.php?error=5"); die;}
 if (($_POST["numeroDifensori"]+$_POST["numeroCentrocampisti"]+$_POST["numeroAttaccanti"]<10)) {  header("Location: ./viewModulo.new.php?error=6"); die;}
 if (Fantacalcio::checkModuloEsistente($_POST["numeroDifensori"],$_POST["numeroCentrocampisti"],$_POST["numeroAttaccanti"])) {  header("Location: ./viewModulo.new.php?error=7"); die;}
    
 $result = Fantacalcio::inserisciModulo($_POST["numeroAttaccanti"],$_POST["numeroDifensori"],$_POST["numeroCentrocampisti"]);


 if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=1");
}

?>