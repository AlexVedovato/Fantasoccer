<?php

    session_start();
    require_once('Fantacalcio.php');

    if(empty($_SESSION["id_pagellista"])){
        header("Location: ./login.php?type=Pagellista");die;
    }

    if(!isset($_GET["numero_giornata"]) || $_GET["numero_giornata"]==''){
        header("Location: ./AreaPagellista.php?error=5"); die;
    }

    if(isset($_GET["id_squadra_SerieA_casa"]) && $_GET["id_squadra_SerieA_casa"]!='' && isset($_GET["id_squadra_SerieA_trasferta"]) && $_GET["id_squadra_SerieA_trasferta"]!=''){
        if (!isset($_GET["id_calciatore"]) || $_GET["id_calciatore"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_GET["numero_giornata"]."&id_squadra_SerieA_casa=".$_GET["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$id_squadra_SerieA_trasferta."&error=1"); die;}
    } else {
        if (!isset($_GET["id_calciatore"]) || $_GET["id_calciatore"]=='') {  header("Location: .AreaPagellista.php?error=6"); die;}
    }

    $result=Fantacalcio::eliminaPrestazione($_GET["numero_giornata"],$_GET["id_calciatore"]);
    
    if($result){
        if(isset($_GET["id_squadra_SerieA_casa"]) && isset($_GET["id_squadra_SerieA_trasferta"])){
            header("Location: ./VotiPartita.php?numero_giornata=".$_GET["numero_giornata"]."&id_squadra_SerieA_casa=".$_GET["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_GET["id_squadra_SerieA_trasferta"]);
        } else {
            header("Location: ./AreaPagellista.php?error=7"); die;
        }
    } else {
        if(isset($_GET["id_squadra_SerieA_casa"]) && isset($_GET["id_squadra_SerieA_trasferta"])){
            header("Location: ./VotiPartita.php?numero_giornata=".$_GET["numero_giornata"]."&id_squadra_SerieA_casa=".$_GET["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_GET["id_squadra_SerieA_trasferta"]."&error=2");
        } else {
            header("Location: .AreaPagellista.php?error=8"); die;
        }
    }
?> 