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

 if (count($_POST)!=3) { header("Location: ./AcquistaCalciatori.php?error=1"); die; }
 if (empty($_POST["id_fantasquadra"])) {  header("Location: ./AcquistaCalciatori.php?error=2"); die;}
 if (empty($_POST["id_calciatore"])) {  header("Location: ./AcquistaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=3"); die;}
 if (empty($_POST["costo_acquisto"])) {  header("Location: ./AcquistaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=4"); die;}
 if (Fantacalcio::getCreditiFantasquadra($_POST["id_fantasquadra"])-$_POST["costo_acquisto"]<0) {  header("Location: ./AcquistaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=5"); die;}
 $calciatoriPerRuolo=Fantacalcio::getNumeroGiocatoriRuoloFantasquadra($_POST["id_fantasquadra"]);
 $regolamento=Fantacalcio::getRegolamento($_SESSION["id_fantalega"]);
 $ruoloCalciatore=Fantacalcio::getCalciatore($_POST["id_calciatore"])["ruolo"];
 if(($ruoloCalciatore=="Portiere" && $calciatoriPerRuolo["numero_portieri"]==$regolamento["numero_portieri"]) || ($ruoloCalciatore=="Difensore" && $calciatoriPerRuolo["numero_difensori"]==$regolamento["numero_difensori"]) ||
 ($ruoloCalciatore=="Centrocampista" && $calciatoriPerRuolo["numero_centrocampisti"]==$regolamento["numero_centrocampisti"]) || ($ruoloCalciatore=="Attaccante" && $calciatoriPerRuolo["numero_attaccanti"]==$regolamento["numero_attaccanti"])){
    header("Location: ./AcquistaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=6"); die;
 }
 $result = Fantacalcio::AcquistaCalciatore($_POST["id_calciatore"],$_POST["id_fantasquadra"],$_POST["costo_acquisto"]);
 if($result){
    header("Location: ./AcquistaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]);
} else {
    header("Location: ./AcquistaCalciatori.php?id_fantasquadra=".$_POST["id_fantasquadra"]."&error=1");
}
?>