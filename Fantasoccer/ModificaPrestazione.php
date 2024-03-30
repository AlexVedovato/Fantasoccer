<?php

    session_start();
    require_once('Fantacalcio.php');

    if(empty($_SESSION["id_pagellista"])){
        header("Location: ./login.php?type=Pagellista");die;
    }

    if(!isset($_POST["numero_giornata"]) || $_POST["numero_giornata"]==''){
        header("Location: ./AreaPagellista.php?error=23"); die;
    }

    if(isset($_POST["id_squadra_SerieA_casa"]) && $_POST["id_squadra_SerieA_casa"]!='' && isset($_POST["id_squadra_SerieA_trasferta"]) && $_POST["id_squadra_SerieA_trasferta"]!=''){
        if (count($_POST)<12) { header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=15"); die; }
        if (!isset($_POST["id_calciatore"]) || $_POST["id_calciatore"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=16"); die;}
        if (!isset($_POST["voto"]) || $_POST["voto"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=17"); die;}
        if (!isset($_POST["goal_azione"]) || $_POST["goal_azione"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=18"); die;}
        if (!isset($_POST["goal_rigore"]) || $_POST["goal_rigore"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=19"); die;}
        if (!isset($_POST["rigori_sbagliati"]) || $_POST["rigori_sbagliati"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=20"); die;}
        if (!isset($_POST["assist"]) || $_POST["assist"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=21"); die;}
        if (!isset($_POST["autogol"]) || $_POST["autogol"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=22"); die;}
        if (!isset($_POST["goal_subiti"]) || $_POST["goal_subiti"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=23"); die;}
        if (!isset($_POST["rigori_parati"]) || $_POST["rigori_parati"]=='') {  header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=24"); die;}
    } else {
        if (count($_POST)<10) { header("Location: ./AreaPagellista.php?error=24"); die; }
        if (!isset($_POST["id_calciatore"]) || $_POST["id_calciatore"]=='') {  header("Location: ./AreaPagellista.php?error=25"); die;}
        if (!isset($_POST["voto"]) || $_POST["voto"]=='') {  header("Location: ./AreaPagellista.php?error=26"); die;}
        if (!isset($_POST["goal_azione"]) || $_POST["goal_azione"]=='') {  header("Location: ./AreaPagellista.php?error=27"); die;}
        if (!isset($_POST["goal_rigore"]) || $_POST["goal_rigore"]=='') {  header("Location: ./AreaPagellista.php?error=28"); die;}
        if (!isset($_POST["rigori_sbagliati"]) || $_POST["rigori_sbagliati"]=='') {  header("Location: ./AreaPagellista.php?error=29"); die;}
        if (!isset($_POST["assist"]) || $_POST["assist"]=='') {  header("Location: ./AreaPagellista.php?error=30"); die;}
        if (!isset($_POST["autogol"]) || $_POST["autogol"]=='') {  header("Location: ./AreaPagellista.php?error=31"); die;}
        if (!isset($_POST["goal_subiti"]) || $_POST["goal_subiti"]=='') {  header("Location: ./AreaPagellista.php?error=32"); die;}
        if (!isset($_POST["rigori_parati"]) || $_POST["rigori_parati"]=='') {  header("Location: ./AreaPagellista.php?error=33"); die;}
    }
    
    if((isset($_POST["goal_decisivo_pareggioSN"]) || isset($_POST["goal_decisivo_vittoriaSN"])) && ($_POST["goal_azione"]==0 && $_POST["goal_rigore"]==0)){
        if(isset($_POST["id_squadra_SerieA_casa"]) && $_POST["id_squadra_SerieA_casa"]!='' && isset($_POST["id_squadra_SerieA_trasferta"]) && $_POST["id_squadra_SerieA_trasferta"]!=''){
            header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=25"); die;
        } else {
            if (!isset($_POST["rigori_parati"]) || $_POST["rigori_parati"]=='') {  header("Location: ./AreaPagellista.php?error=34"); die;}
        }
    }

    $result=Fantacalcio::modificaPrestazione($_POST["voto"],$_POST["goal_azione"],$_POST["assist"],isset($_POST["ammonizioneSN"])?'S':'N',isset($_POST["espulsioneSN"])?'S':'N',$_POST["goal_subiti"],$_POST["rigori_parati"],$_POST["numero_giornata"],$_POST["id_calciatore"],isset($_POST["goal_decisivo_pareggioSN"])?'S':'N',isset($_POST["goal_decisivo_vittoriaSN"])?'S':'N',$_POST["rigori_sbagliati"],$_POST["goal_rigore"],$_POST["autogol"],isset($_POST["entratoSN"])?'S':'N',isset($_POST["uscitoSN"])?'S':'N');

    if($result){
        if(isset($_POST["id_squadra_SerieA_casa"]) && $_POST["id_squadra_SerieA_casa"]!='' && isset($_POST["id_squadra_SerieA_trasferta"]) && $_POST["id_squadra_SerieA_trasferta"]!=''){
            header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]); die;
        } else {
            header("Location: ./AreaPagellista.php?error=35");
        }
    } else {
        if(isset($_POST["id_squadra_SerieA_casa"]) && $_POST["id_squadra_SerieA_casa"]!='' && isset($_POST["id_squadra_SerieA_trasferta"]) && $_POST["id_squadra_SerieA_trasferta"]!=''){
            header("Location: ./VotiPartita.php?numero_giornata=".$_POST["numero_giornata"]."&id_squadra_SerieA_casa=".$_POST["id_squadra_SerieA_casa"]."&id_squadra_SerieA_trasferta=".$_POST["id_squadra_SerieA_trasferta"]."&error=26"); die;
        } else {
            header("Location: ./AreaPagellista.php?error=36");
        }
    }
?> 