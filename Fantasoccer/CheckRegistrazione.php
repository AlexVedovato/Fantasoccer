<?php
     session_start();
     require_once('Fantacalcio.php');

     if (count($_POST)!=3 ) { header("Location: ./registrazione.php?error=1"); die; }
     if (empty($_POST["usernameRegistrazione"])) {  header("Location: ./registrazione.php?error=2"); die;}
     if (empty($_POST["emailRegistrazione"])) {  header("Location: ./registrazione.php?error=3"); die;}
     if (empty($_POST["password"])) {  header("Location: ./registrazione.php?error=4"); die;}

     $result=Fantacalcio::checkUtenteEsistente($_POST["usernameRegistrazione"],$_POST["emailRegistrazione"]);

     if($result!=null){
        header("Location: ./registrazione.php?error=".$result); die;
     }else{
        $id_fantallenatore= Fantacalcio::getNextIdFantallenatore(); 
        $result= Fantacalcio::inserisciFantallenatore($_POST["usernameRegistrazione"],$_POST["emailRegistrazione"],$_POST["password"],$id_fantallenatore);
        $_SESSION["id_fantallenatore"]=$id_fantallenatore;
        header("Location: ./SelezionaLega.php");
     } 
     
?>