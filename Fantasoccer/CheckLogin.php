<?php

    session_start();
    require_once('Fantacalcio.php');

    if(isset($_POST["type"])){
        if($_POST["type"]=="Pagellista"){
            if(!empty($_SESSION["id_pagellista"])){
                header("Location: ./AreaPagellista.php");die;
            }
        } else if($_POST["type"]=="Admin"){
            if(!empty($_SESSION["id_admin"])){
                header("Location: ./AreaAdmin.php");die;
            }
        } else {
            header("Location: ./PaginaIniziale.html");die;
        }
        $type=$_POST["type"];
    } else {
        if(!empty($_SESSION["id_fantallenatore"])){
            header("Location: ./SelezionaLega.php");die;
        }
        $type="Fantallenatore";
    }

    if($type!="Fantallenatore"){
        if (count($_POST)!=3 ) { header("Location: ./Login.php?type=".$type."&error=1"); die; }
        if (empty($_POST["username"])) {  header("Location: ./Login.php?type=".$type."&error=2"); die;}
        if (empty($_POST["password"])) {  header("Location: ./Login.php?type=".$type."&error=3"); die;}
        $result=Fantacalcio::checkLogin($_POST["username"],$_POST["password"],$type);
    } else {
        if (count($_POST)!=2 ) { header("Location: ./Login.php?error=1"); die; }
        if (empty($_POST["usernameOrEmail"])) {  header("Location: ./Login.php?error=4"); die;}
        if (empty($_POST["password"])) {  header("Location: ./Login.php?error=3"); die;}
        $result=Fantacalcio::checkLogin($_POST["usernameOrEmail"],$_POST["password"],$type);
    }


    if($result!=NULL){
        if($type=="Fantallenatore"){
            $_SESSION["id_fantallenatore"]=$result;
            header("Location: ./SelezionaLega.php");
        } else if ($type=="Pagellista"){
            $_SESSION["id_pagellista"]=$result;
            header("Location: ./AreaPagellista.php");
        } else {
            $_SESSION["id_admin"]=$result;
            header("Location: ./AreaAdmin.php");
        }
    } else {
        if($type=="Fantallenatore"){
            header("Location: ./Login.php?error=5");
        } else {
            header("Location: ./Login.php?type=".$type."&error=6");
        }
    }

?>