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

//TODO  fare errori sull' area fantallenatore
if (count($_GET) < 3) {
  header("Location: ./AreaFantallenatore.php?error=1");
  die;
}
if (empty($_GET["numero_giornata"])) {
  header("Location: ./AreaFantallenatore.php?error=2");
  die;
}
if (empty($_GET["id_fantasquadra_casa"])) {
  header("Location: ./AreaFantallenatore.php?error=3");
  die;
}
if (empty($_GET["id_fantasquadra_trasferta"])) {
  header("Location: ./AreaFantallenatore.php?error=4");
  die;
}
$idSquadreFantalega = Fantacalcio::getIDSquadreFantalega($_SESSION["id_fantalega"]);
array_push($idSquadreFantalega, -1);

if (!in_array($_GET["id_fantasquadra_casa"], $idSquadreFantalega) || !in_array($_GET["id_fantasquadra_trasferta"], $idSquadreFantalega)) {
  header("Location: ./AreaFantallenatore.php?error=5");
  die;
}
$partitaFantacalcio = Fantacalcio::getPartitaFantacalcio($_GET["id_fantasquadra_casa"], $_GET["id_fantasquadra_trasferta"], $_GET["numero_giornata"]);
if ($partitaFantacalcio == null) {
  header("Location: ./AreaFantallenatore.php?error=6");
  die;
}


$fantasquadra_casa = Fantacalcio::getNomeStemmaFantasquadra($_GET["id_fantasquadra_casa"]);
$modulo_casa = Fantacalcio::getModulo(Fantacalcio::getModuloFormazione($_GET["id_fantasquadra_casa"], $_GET["numero_giornata"]));
if ($modulo_casa != null) {
  $calciatori_casa = Fantacalcio::getCalciatoriFormazione($_GET["id_fantasquadra_casa"], $_GET["numero_giornata"]);
}
$fantasquadra_trasferta = Fantacalcio::getNomeStemmaFantasquadra($_GET["id_fantasquadra_trasferta"]);
$modulo_trasferta = Fantacalcio::getModulo(Fantacalcio::getModuloFormazione($_GET["id_fantasquadra_trasferta"], $_GET["numero_giornata"]));
if ($modulo_trasferta != null) {
  $calciatori_trasferta = Fantacalcio::getCalciatoriFormazione($_GET["id_fantasquadra_trasferta"], $_GET["numero_giornata"]);
}
$immagini_bonus = Fantacalcio::getImmaginiBonus();
$punteggioCasaParziale=0;
$punteggioTrasfertaParziale=0;
?>

<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./css/ViewDettaglioPartitaFantacalcio.css">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
  <script src="popper-1.15.0/js/popper.min.js"></script>
  <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>

</head>

<body>

  <table class="table table-bordered tableFixHead">
    <thead class="thead-dark borderless">
      <tr>
        <?php
        echo '<th><h1>' . $fantasquadra_casa["nome"] . '</h1>';
        if ($fantasquadra_casa["stemma"] == NULL) {
          echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
        } else {
          echo '<img src="data:image/jpeg;base64,' . $fantasquadra_casa["stemma"] . '" alt="' . $fantasquadra_casa["nome"] . '"/>';
        }
        if($modulo_casa!= null){
          echo '<br>'; 
          echo '<br>'; 
          echo $modulo_casa["numero_difensori"].'-'.$modulo_casa["numero_centrocampisti"].'-'.$modulo_casa["numero_attaccanti"];
        } else {
          echo '<br>'; 
          echo '<br>'; 
          echo '-';
        }
        echo '</th>';

        if ($partitaFantacalcio["punteggio_casa"] != null && $partitaFantacalcio["punteggio_trasferta"] != null) {
          echo '<th class="align-middle "><h1 class="risultato">' . Fantacalcio::getGoals($partitaFantacalcio["punteggio_casa"], $_SESSION["id_fantalega"]) . '-' . Fantacalcio::getGoals($partitaFantacalcio["punteggio_trasferta"], $_SESSION["id_fantalega"]) . '</h1></th>';
        }


        echo '<th><h1>' . $fantasquadra_trasferta["nome"] . '</h1>';
        if ($fantasquadra_trasferta["stemma"] == NULL) {
          echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
        } else {
          echo '<img src="data:image/jpeg;base64,' . $fantasquadra_trasferta["stemma"] . '" alt="' . $fantasquadra_trasferta["nome"] . '"/>';
        }
        if($modulo_trasferta!= null){
          echo '<br>'; 
          echo '<br>'; 
          echo $modulo_trasferta["numero_difensori"].'-'.$modulo_trasferta["numero_centrocampisti"].'-'.$modulo_trasferta["numero_attaccanti"];
        }else {
          echo '<br>'; 
          echo '<br>'; 
          echo '-';
        }
        echo '</th>';
        ?>
      </tr>
      </thead>
      </table>
      <table class="table table-bordered tableFixHead"> 
    <tbody>
      <?php
      echo '<tr>';

      if ($modulo_casa == null) {
        echo '<td class="align-middle nonInserita"><h2>Formazione non inserita</h2></td>';
        
      } else {
        $calciatore = Fantacalcio::getCalciatore($calciatori_casa[0]["id_calciatore"]);
        $prestazione = Fantacalcio::getPrestazione($_GET["numero_giornata"], $calciatori_casa[0]["id_calciatore"]);
        if ($prestazione == NULL || Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)=="SV") {
          if($partitaFantacalcio["punteggio_casa"]!= null && $partitaFantacalcio["punteggio_trasferta"]!=null){
            echo '<td class="sfondogrigio">';
          }else{
            echo '<td>';
          }
          echo '<img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> - </h2> </div> <h2>
          &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2> - </h2> </div> ';
        }

        if ($prestazione != null && Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)!="SV") {
          echo '<td><img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> ' . str_replace("-1", "SV", $prestazione["voto"]) . ' </h2> </div> <h2>
                &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2>' . Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], true) . '</h2> </div> ';
          if(Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], true)!="SV"){
            $punteggioCasaParziale+=Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], true);
          }
          echo '<div class="container" align="center">';
          echo '<div class="row align-items-center">';
          for ($i = 0; $i < $prestazione["goal_subiti"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal subito"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["rigori_parati"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore parato"] . '"/><br>';
          }
          if ($prestazione["goal_subiti"] == 0) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["portiere imbattuto"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["autogol"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["autogol"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["assist"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["assist"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["goal_azione"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal segnato"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["goal_rigore"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore segnato"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["rigori_sbagliati"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore sbagliato"] . '"/><br>';
          }
          if ($prestazione["goal_decisivo_pareggioSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo pareggio"] . '"/><br>';
          }
          if ($prestazione["goal_decisivo_vittoriaSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo vittoria"] . '"/><br>';
          }
          if ($prestazione["ammonizioneSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["ammonizione"] . '"/><br>';
          }
          if ($prestazione["espulsioneSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["espulsione"] . '"/><br>';
          }
          if ($prestazione["entratoSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["entrato"] . '"/><br>';
          }
          if ($prestazione["uscitoSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["uscito"] . '"/><br>';
          }
          echo '</div></td> ';
        }
      }

      if ($modulo_trasferta == null ) {
        echo '<td class="align-middle nonInserita"><h2>Formazione non inserita</h2></td>';
      } else {
        $calciatore = Fantacalcio::getCalciatore($calciatori_trasferta[0]["id_calciatore"]);
        $prestazione = Fantacalcio::getPrestazione($_GET["numero_giornata"], $calciatori_trasferta[0]["id_calciatore"]);

        if ($prestazione == NULL || Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)=="SV") {
          if($partitaFantacalcio["punteggio_casa"]!= null && $partitaFantacalcio["punteggio_trasferta"]!=null){
            echo '<td class="sfondogrigio">';
          }else{
            echo '<td>';
          }
          echo '<img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> - </h2> </div> <h2>
                &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2> - </h2> </div> ';
        }

        if ($prestazione != null && Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)!="SV") {
          echo '<td><img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> ' . str_replace("-1", "SV", $prestazione["voto"]) . ' </h2> </div> <h2>
                &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2>' . Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], true) . '</h2> </div> ';
          if(Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], true)!="SV"){
            $punteggioTrasfertaParziale+=Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], true);
          }   
          echo '<div class="container" align="center">';
          echo '<div class="row align-items-center">';
          for ($i = 0; $i < $prestazione["goal_subiti"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal subito"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["rigori_parati"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore parato"] . '"/><br>';
          }
          if ($prestazione["goal_subiti"] == 0) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["portiere imbattuto"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["autogol"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["autogol"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["assist"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["assist"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["goal_azione"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal segnato"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["goal_rigore"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore segnato"] . '"/><br>';
          }
          for ($i = 0; $i < $prestazione["rigori_sbagliati"]; $i++) {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore sbagliato"] . '"/><br>';
          }
          if ($prestazione["goal_decisivo_pareggioSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo pareggio"] . '"/><br>';
          }
          if ($prestazione["goal_decisivo_vittoriaSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo vittoria"] . '"/><br>';
          }
          if ($prestazione["ammonizioneSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["ammonizione"] . '"/><br>';
          }
          if ($prestazione["espulsioneSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["espulsione"] . '"/><br>';
          }
          if ($prestazione["entratoSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["entrato"] . '"/><br>';
          }
          if ($prestazione["uscitoSN"] == 'S') {
            echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["uscito"] . '"/><br>';
          }
          echo '</div></td> ';
        }
      }
      echo '</tr>';

      for ($j = 1; $j < 21 && ($modulo_casa!=null || $modulo_trasferta!=null); $j++) {

        if ($j == 11 && ($modulo_casa!=null || $modulo_trasferta!=null) ) {
          //riga separazione per panchina
          echo'<tr><td class= "thead-dark panchina" colspan="2"><h2>PANCHINA</h2></td></tr> ';
        }
        echo '<tr>';
        if ($modulo_casa != null) {
          $calciatore = Fantacalcio::getCalciatore($calciatori_casa[$j]["id_calciatore"]);
          $prestazione = Fantacalcio::getPrestazione($_GET["numero_giornata"], $calciatori_casa[$j]["id_calciatore"]);

          if ($prestazione == NULL || Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)=="SV") {
            if($partitaFantacalcio["punteggio_casa"]!= null && $partitaFantacalcio["punteggio_trasferta"]!=null  && $j<11){
              echo '<td class="sfondogrigio">';
            }else{
              echo '<td>';
            }
            echo '<img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> - </h2> </div> <h2>
            &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2> - </h2> </div> ';
          }
          if ($prestazione != null && Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)!="SV") {
            echo '<td><img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> ' . str_replace("-1", "SV", $prestazione["voto"]) . ' </h2> </div> <h2>
            &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2>' . Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], $j==11) . '</h2> </div> ';
            if($j<11 && Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], false)!="SV"){
              $punteggioCasaParziale+=Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], false);
            }
            echo '<div class="container" align="center">';
            echo '<div class="row align-items-center">';
            for ($i = 0; $i < $prestazione["goal_subiti"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal subito"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["rigori_parati"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore parato"] . '"/><br>';
            }
            if ($prestazione["goal_subiti"] == 0 && $j==11  && $prestazione["voto"]!=-1) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["portiere imbattuto"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["autogol"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["autogol"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["assist"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["assist"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["goal_azione"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal segnato"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["goal_rigore"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore segnato"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["rigori_sbagliati"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore sbagliato"] . '"/><br>';
            }
            if ($prestazione["goal_decisivo_pareggioSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo pareggio"] . '"/><br>';
            }
            if ($prestazione["goal_decisivo_vittoriaSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo vittoria"] . '"/><br>';
            }
            if ($prestazione["ammonizioneSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["ammonizione"] . '"/><br>';
            }
            if ($prestazione["espulsioneSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["espulsione"] . '"/><br>';
            }
            if ($prestazione["entratoSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["entrato"] . '"/><br>';
            }
            if ($prestazione["uscitoSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["uscito"] . '"/><br>';
            }
            echo '</div></td> ';
          }
        } else {
          echo '<td style="border:0px"></td>';

        }

        if ($modulo_trasferta != null) {
          $calciatore = Fantacalcio::getCalciatore($calciatori_trasferta[$j]["id_calciatore"]);
          $prestazione = Fantacalcio::getPrestazione($_GET["numero_giornata"], $calciatori_trasferta[$j]["id_calciatore"]);

          if ($prestazione == NULL || Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)=="SV") {
            if($partitaFantacalcio["punteggio_casa"]!= null && $partitaFantacalcio["punteggio_trasferta"]!=null  && $j<11){
              echo '<td class="sfondogrigio">';
            }else{
              echo '<td>';
            }
            echo '<img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> - </h2> </div> <h2>
            &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2> - </h2> </div> ';
          }

          if ($prestazione != null && Fantacalcio::getFantavoto($prestazione,$_SESSION["id_fantalega"],false)!="SV") {
            echo '<td><img style="float:left" src="./images/Default/' . $calciatore["ruolo"] . '.png" class="rounded-circle" alt="' . $calciatore["ruolo"] . '"/> <div class="float-right align-self-center"> <h2> ' . str_replace("-1", "SV", $prestazione["voto"]) . ' </h2> </div> <h2>
                  &nbsp' . substr($calciatore["nome"], 0, 2) . '. ' . $calciatore["cognome"] . '</h2> <div class="float-right align-self-center fantavoto"> <h2>' . Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], $j==11) . '</h2> </div> ';
            if($j<11 && Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], false)!="SV"){
              $punteggioTrasfertaParziale+=Fantacalcio::getFantavoto($prestazione, $_SESSION["id_fantalega"], false);
            }
            echo '<div class="container" align="center">';
            echo '<div class="row align-items-center">';
            for ($i = 0; $i < $prestazione["goal_subiti"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal subito"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["rigori_parati"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore parato"] . '"/><br>';
            }
            if ($prestazione["goal_subiti"] == 0 && $j==11 && $prestazione["voto"]!=-1) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["portiere imbattuto"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["autogol"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["autogol"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["assist"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["assist"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["goal_azione"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal segnato"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["goal_rigore"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore segnato"] . '"/><br>';
            }
            for ($i = 0; $i < $prestazione["rigori_sbagliati"]; $i++) {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["rigore sbagliato"] . '"/><br>';
            }
            if ($prestazione["goal_decisivo_pareggioSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo pareggio"] . '"/><br>';
            }
            if ($prestazione["goal_decisivo_vittoriaSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["goal decisivo vittoria"] . '"/><br>';
            }
            if ($prestazione["ammonizioneSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["ammonizione"] . '"/><br>';
            }
            if ($prestazione["espulsioneSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["espulsione"] . '"/><br>';
            }
            if ($prestazione["entratoSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["entrato"] . '"/><br>';
            }
            if ($prestazione["uscitoSN"] == 'S') {
              echo '<img class="bonus" src="data:image/jpeg;base64,' . $immagini_bonus["uscito"] . '"/><br>';
            }
            echo '</div></td> ';
          }
        } else {
          echo '<td style="border:0px"></td>';
        }
       
        echo '</tr>';
      }

     if($modulo_casa!=null || $modulo_trasferta!=null){
      echo '<tr><td colspan="2">';
      echo '<div class ="row">';
      if($partitaFantacalcio["punteggio_casa"]== null ||$partitaFantacalcio["punteggio_trasferta"]==null ){
        echo '<div class ="col text-center"><h2>'.$punteggioCasaParziale.'</h2></div>';
        echo '<div class ="col text-center"><h2>Punteggi parziali</h2></div>';
        echo '<div class ="col text-center"><h2>'.$punteggioTrasfertaParziale.'</h2></div>';
      }else {
        echo '<div class ="col text-center"><h2>'.$partitaFantacalcio["punteggio_casa"].'</h2></div>';
        echo '<div class ="col text-center"><h2>Punteggi finali</h2></div>';
        echo '<div class ="col text-center"><h2>'.$partitaFantacalcio["punteggio_trasferta"].'</h2></div>';
      }
      echo '</div>'; 
      echo '</td></tr>';
     }
      ?>

    </tbody>
  </table>

  <?php
    if($modulo_casa==null && $modulo_trasferta==null){
      echo '<div class="fixed-bottom row border">';
      if($partitaFantacalcio["punteggio_casa"]== null ||$partitaFantacalcio["punteggio_trasferta"]==null ){
        echo '<div class ="col text-center"><h2>'.$punteggioCasaParziale.'</h2></div>';
        echo '<div class ="col text-center"><h2>Punteggi parziali</h2></div>';
        echo '<div class ="col text-center"><h2>'.$punteggioTrasfertaParziale.'</h2></div>';
      }else {
        echo '<div class ="col text-center"><h2>'.$partitaFantacalcio["punteggio_casa"].'</h2></div>';
        echo '<div class ="col text-center"><h2>Punteggi finali</h2></div>';
        echo '<div class ="col text-center"><h2>'.$partitaFantacalcio["punteggio_trasferta"].'</h2></div>';
      }
      echo '</div>';
     }
  ?>

</body>


</html>