<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if (empty($_POST["id_pagellista"])) {  header("Location: ./index.php?error=5"); die;}
if (count($_POST)!=3) { header("Location: ./viewPagellista.update.php?id_pagellista=".$_POST["id_pagellista"]."&error=1"); die; }
if (empty($_POST["username"])) {  header("Location: ./viewPagellista.update.php?id_pagellista=".$_POST["id_pagellista"]."&error=2"); die;}
if($_POST["username"]!=Fantacalcio::getPagellista($_POST["id_pagellista"])["username"]){
    if (Fantacalcio::checkPagellistaEsistente($_POST["username"])) {  header("Location: ./viewPagellista.update.php?id_pagellista=".$_POST["id_pagellista"]."&error=4"); die;}
}
if(empty($_POST["password"])) {
    $result = Fantacalcio::modificaPagellistaNoPassword($_POST["id_pagellista"],$_POST["username"]); 
} else {
    $result = Fantacalcio::modificaPagellista($_POST["id_pagellista"],$_POST["username"],$_POST["password"]); 
}

if($result){
    header("Location: ./index.php");
} else {
    header("Location: ./index.php?error=3");
}
?>