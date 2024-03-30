<?php
    require_once('Fantacalcio.php');
    session_start();
    
    if(empty($_SESSION["id_pagellista"])){
      header("Location: ./login.php?type=Pagellista");die;
    }

    if (count($_GET)<3 ) { header("Location: ./AreaPagellista.php?error=1"); die; }
    if (empty($_GET["numero_giornata"])) {  header("Location: ./AreaPagellista.php?error=2"); die;}
    if (empty($_GET["id_squadra_SerieA_casa"])) {  header("Location: ./AreaPagellista.php?error=3"); die;}
    if (empty($_GET["id_squadra_SerieA_trasferta"])) {  header("Location: ./AreaPagellista.php?error=4"); die;}

    $partita=Fantacalcio::getPartitaSerieA($_GET["numero_giornata"],$_GET["id_squadra_SerieA_casa"],$_GET["id_squadra_SerieA_trasferta"]);

    if($partita==NULL){
      header("Location: ./AreaPagellista.php?error=37"); die;
    }

    $squadra_casa=Fantacalcio::getNomeStemmaSquadra($_GET["id_squadra_SerieA_casa"]);
    $calciatori_casa=Fantacalcio::getCalciatoriSquadra($_GET["id_squadra_SerieA_casa"]);
    $squadra_trasferta=Fantacalcio::getNomeStemmaSquadra($_GET["id_squadra_SerieA_trasferta"]);
    $calciatori_trasferta=Fantacalcio::getCalciatoriSquadra($_GET["id_squadra_SerieA_trasferta"]);
    $immagini_bonus=Fantacalcio::getImmaginiBonus();
?>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/VotiPartita.css">
    <script src="./js/VotiPartita.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>

  </head>

  <body>
  <?php
      if(isset($_GET['error'])){
        ?><!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">C'è un problema!!!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php
                  if ($_GET['error']==1){
                    echo 'Manca l\'id del calciatore, il quale è indispensabile per poter eliminare la sua prestazione.';
                  } else if($_GET['error']==2){
                    echo 'Per un qualche motivo non è stato possibile eliminare la prestazione del calciatore.';
                  } else if($_GET['error']==3){
                    echo 'Mancano i dati necessari per poter inserire la prestazione del calciatore.';
                  } else if($_GET['error']==4){
                    echo 'Manca l\'id del calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==5){
                    echo 'Manca il voto del calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==6){
                    echo 'Manca il numero di goal su azione del calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==7){
                    echo 'Manca il numero di goal su rigore del calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==8){
                    echo 'Manca il numero di rigori sbagliati dal calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==9){
                    echo 'Manca il numero di assist del calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==10){
                    echo 'Manca il numero di autogol del calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==11){
                    echo 'Manca il numero di goal subiti dal calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==12){
                    echo 'Manca il numero di rigori parati dal calciatore, il quale è indispensabile per poter inserire la sua prestazione.';
                  } else if($_GET['error']==13){
                    echo 'Non è stato possibile inserire la prestazione perchè il calciatore non può aver fatto un goal decisivo se non ha nemmeno segnato.';
                  } else if($_GET['error']==14){
                    echo 'Per un qualche motivo non è stato possibile inserire la prestazione del calciatore.';
                  } else if($_GET['error']==15){
                    echo 'Mancano i dati necessari per poter modificare la prestazione del calciatore.';
                  } else if($_GET['error']==16){
                    echo 'Manca l\'id del calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==17){
                    echo 'Manca il voto del calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==18){
                    echo 'Manca il numero di goal su azione del calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==19){
                    echo 'Manca il numero di goal su rigore del calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==20){
                    echo 'Manca il numero di rigori sbagliati dal calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==21){
                    echo 'Manca il numero di assist del calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==22){
                    echo 'Manca il numero di autogol del calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==23){
                    echo 'Manca il numero di goal subiti dal calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==24){
                    echo 'Manca il numero di rigori parati dal calciatore, il quale è indispensabile per poter modificare la sua prestazione.';
                  } else if($_GET['error']==25){
                    echo 'Non è stato possibile modificare la prestazione perchè il calciatore non può aver fatto un goal decisivo se non ha nemmeno segnato.';
                  } else if($_GET['error']==26){
                    echo 'Per un qualche motivo non è stato possibile modificare la prestazione del calciatore.';
                  } else {
                    echo 'Errore sconosciuto.';
                  }
                ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK!</button>
              </div>
            </div>
          </div>
        </div>
        <script>
        $('#modal').modal('show');
        </script>
        <?php
      }
    ?>
    
      <table class="table table-bordered tableFixHead">
        <thead class="thead-dark borderless">
          <tr>
            <?php 
            echo '<th><h1>'.$squadra_casa["nome"].'</h1>';
            if($squadra_casa["stemma"]==NULL){
              echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
            } else {
              echo '<img src="data:image/jpeg;base64,'.$squadra_casa["stemma"].'" alt="stemma_'.$squadra_casa["nome"].'"/>';
            }
            echo '</th>';
            ?>
            <?php 
            echo '<th><h1>'.$squadra_trasferta["nome"].'</h1>';
            if($squadra_trasferta["stemma"]==NULL){
              echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
            } else {
              echo '<img src="data:image/jpeg;base64,'.$squadra_trasferta["stemma"].'" alt="stemma_'.$squadra_trasferta["nome"].'"/>';
            }
            echo '</th>';
            ?>
            <th style="padding-bottom: 65px"><button onclick="location.href='./AreaPagellista.php?numero_giornata=<?php echo($_GET['numero_giornata']) ?>'" class="btn btn-warning mt-3 mb-3 float-right ">Torna Indietro </th>
          </tr>
        </thead>
        <tbody>
          <?php
              $n=sizeof($calciatori_casa);
              if(sizeof($calciatori_trasferta)>$n){
                $n=sizeof($calciatori_trasferta);
              }
              for($i=0;$i<$n;$i++){
                echo '<tr>';
                if($i<sizeof($calciatori_casa)){
                  echo '<td><img style="float:left" src="./images/Default/'.$calciatori_casa[$i]["ruolo"].'.png" class="rounded-circle" alt="'.$calciatori_casa[$i]["ruolo"].'"/><h2>
                  &nbsp'.$calciatori_casa[$i]["nome"].' '.$calciatori_casa[$i]["cognome"].'</h2>';
                    echo '<div class="container" align="center">';
                    $prestazione=Fantacalcio::getPrestazione($_GET["numero_giornata"],$calciatori_casa[$i]["id_calciatore"]);
                    if($prestazione==NULL){
                      echo '<form action="inserisciPrestazione.php" method="POST">';
                    } else {
                      echo '<form action="modificaPrestazione.php" method="POST">';
                    }
                    echo '<input type="number" name="numero_giornata" value="'.$_GET["numero_giornata"].'" hidden>';
                    echo '<input type="number" name="id_calciatore" value="'.$calciatori_casa[$i]["id_calciatore"].'" hidden>';
                    echo '<input type="number" name="id_squadra_SerieA_casa" value="'.$_GET["id_squadra_SerieA_casa"].'" hidden>';
                    echo '<input type="number" name="id_squadra_SerieA_trasferta" value="'.$_GET["id_squadra_SerieA_trasferta"].'" hidden>';
                      echo '<div class="row">';
                        echo '<div class="col">';
                          echo '<h3>VOTO</h3>';
                          echo '<select name="voto">';
                            echo '<option value="-1">SV</option>';
                            for($j=3;$j<10.5;$j+=0.5){
                              if($prestazione!=NULL && $prestazione["voto"]==$j){
                                echo '<option selected>'.$j.'</option>';
                              } else {
                                echo '<option>'.$j.'</option>';
                              }
                            }
                          echo '</select>';
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal segnato"].'" alt="gol_segnato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="goal_azione" min="0" value="'.$prestazione["goal_azione"].'">';
                          } else {
                            echo '<input type="number" name="goal_azione" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["rigore segnato"].'" alt="rigore_segnato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="goal_rigore" min="0" value="'.$prestazione["goal_rigore"].'">';
                          } else {
                            echo '<input type="number" name="goal_rigore" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["rigore sbagliato"].'" alt="rigore_sbagliato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="rigori_sbagliati" min="0" value="'.$prestazione["rigori_sbagliati"].'">';
                          } else {
                            echo '<input type="number" name="rigori_sbagliati" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["assist"].'" alt="assist"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="assist" min="0" value="'.$prestazione["assist"].'">';
                          } else {
                            echo '<input type="number" name="assist" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["ammonizione"].'" alt="ammonizione"/><br>';
                          if($prestazione!=NULL && $prestazione["ammonizioneSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'ammonizione".$i."','espulsione".$i."')".'" name="ammonizioneSN" id="ammonizione'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'ammonizione".$i."','espulsione".$i."')".'" name="ammonizioneSN" id="ammonizione'.$i.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["espulsione"].'" alt="espulsione"/><br>';
                          if($prestazione!=NULL && $prestazione["espulsioneSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'espulsione".$i."','ammonizione".$i."')".'" name="espulsioneSN" id="espulsione'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'espulsione".$i."','ammonizione".$i."')".'" name="espulsioneSN" id="espulsione'.$i.'">';
                          }
                        echo '</div>';
                      echo '</div><div class="row">';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal decisivo pareggio"].'" alt="gol_decisivo_pareggio"/><br>';
                          if($prestazione!=NULL && $prestazione["goal_decisivo_pareggioSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_pareggio".$i."','goal_decisivo_vittoria".$i."')".'" name="goal_decisivo_pareggioSN" id="goal_decisivo_pareggio'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_pareggio".$i."','goal_decisivo_vittoria".$i."')".'" name="goal_decisivo_pareggioSN" id="goal_decisivo_pareggio'.$i.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal decisivo vittoria"].'" alt="gol_decisivo_vittoria"/><br>';
                          if($prestazione!=NULL && $prestazione["goal_decisivo_vittoriaSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_vittoria".$i."','goal_decisivo_pareggio".$i."')".'" name="goal_decisivo_vittoriaSN" id="goal_decisivo_vittoria'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_vittoria".$i."','goal_decisivo_pareggio".$i."')".'" name="goal_decisivo_vittoriaSN" id="goal_decisivo_vittoria'.$i.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["autogol"].'" alt="autogol"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="autogol" min="0" value="'.$prestazione["autogol"].'">';
                          } else {
                            echo '<input type="number" name="autogol" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal subito"].'" alt="goal_subito"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="goal_subiti" min="0" value="'.$prestazione["goal_subiti"].'">';
                          } else {
                            echo '<input type="number" name="goal_subiti" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["rigore parato"].'" alt="rigore_parato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="rigori_parati" min="0" value="'.$prestazione["rigori_parati"].'">';
                          } else {
                            echo '<input type="number" name="rigori_parati" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["entrato"].'" alt="entrato"/><br>';
                          if($prestazione!=NULL && $prestazione["entratoSN"]=='S'){
                            echo '<input type="checkbox" name="entratoSN" id="entrato'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" name="entratoSN" id="entrato'.$i.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["uscito"].'" alt="uscito"/><br>';
                          if($prestazione!=NULL && $prestazione["uscitoSN"]=='S'){
                            echo '<input type="checkbox" name="uscitoSN" id="uscito'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" name="uscitoSN" id="uscito'.$i.'">';
                          }
                        echo '</div>';
                      echo '</div>';
                    if($prestazione==NULL){
                      echo '<br><div class="row justify-content-start"><button type="submit" class="btn btn-primary">Inserisci prestazione</button></div></form></div>';
                    } else {
                      echo '<br><div class="row justify-content-between">';
                        echo '<div class="col-sm-4"><div class="row justify-content-start"><button type="submit" class="btn btn-warning">Modifica prestazione</button></div></div>';
                        echo '<div class="col-sm-4"><div class="row justify-content-end"><a href="./EliminaPrestazione.php?id_calciatore='.$calciatori_casa[$i]["id_calciatore"].'&numero_giornata='.$_GET["numero_giornata"].'&id_squadra_SerieA_casa='.$_GET["id_squadra_SerieA_casa"].'&id_squadra_SerieA_trasferta='.$_GET["id_squadra_SerieA_trasferta"].'" class="btn btn-danger">Elimina prestazione</button></div></div>';
                      echo '</div></form></div>';
                    }
                  echo '</td>';
                } else {
                  echo '<td></td>';
                }
                if($i<sizeof($calciatori_trasferta)){
                  $k=$i+1000;
                  echo '<td><img style="float:left" src="./images/Default/'.$calciatori_trasferta[$i]["ruolo"].'.png" class="rounded-circle" alt="'.$calciatori_trasferta[$i]["ruolo"].'" alt="'.$calciatori_trasferta[$i]["ruolo"].'"/><h2>
                  &nbsp'.$calciatori_trasferta[$i]["nome"].' '.$calciatori_trasferta[$i]["cognome"].'</h2>';
                  echo '<div class="container" align="center">';
                    $prestazione=Fantacalcio::getPrestazione($_GET["numero_giornata"],$calciatori_trasferta[$i]["id_calciatore"]);
                    if($prestazione==NULL){
                      echo '<form action="inserisciPrestazione.php" method="POST">';
                    } else {
                      echo '<form action="modificaPrestazione.php" method="POST">';
                    }
                    echo '<input type="number" name="numero_giornata" value="'.$_GET["numero_giornata"].'" hidden>';
                    echo '<input type="number" name="id_calciatore" value="'.$calciatori_trasferta[$i]["id_calciatore"].'" hidden>';
                    echo '<input type="number" name="id_squadra_SerieA_casa" value="'.$_GET["id_squadra_SerieA_casa"].'" hidden>';
                    echo '<input type="number" name="id_squadra_SerieA_trasferta" value="'.$_GET["id_squadra_SerieA_trasferta"].'" hidden>';
                      echo '<div class="row">';
                        echo '<div class="col">';
                          echo '<h3>VOTO</h3>';
                          echo '<select name="voto">';
                            echo '<option value="-1">SV</option>';
                            for($j=3;$j<10.5;$j+=0.5){
                              if($prestazione!=NULL && $prestazione["voto"]==$j){
                                echo '<option selected>'.$j.'</option>';
                              } else {
                                echo '<option>'.$j.'</option>';
                              }
                            }
                          echo '</select>';
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal segnato"].'" alt="goal_segnato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="goal_azione" min="0" value="'.$prestazione["goal_azione"].'">';
                          } else {
                            echo '<input type="number" name="goal_azione" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["rigore segnato"].'" alt="rigore_segnato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="goal_rigore" min="0" value="'.$prestazione["goal_rigore"].'">';
                          } else {
                            echo '<input type="number" name="goal_rigore" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["rigore sbagliato"].'" alt="rigore_sbagliato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="rigori_sbagliati" min="0" value="'.$prestazione["rigori_sbagliati"].'">';
                          } else {
                            echo '<input type="number" name="rigori_sbagliati" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["assist"].'" alt="assist"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="assist" min="0" value="'.$prestazione["assist"].'">';
                          } else {
                            echo '<input type="number" name="assist" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["ammonizione"].'" alt="ammonizione"/><br>';
                          if($prestazione!=NULL && $prestazione["ammonizioneSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'ammonizione".$k."','espulsione".$k."')".'" name="ammonizioneSN" id="ammonizione'.$k.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'ammonizione".$k."','espulsione".$k."')".'" name="ammonizioneSN" id="ammonizione'.$k.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["espulsione"].'" alt="espulsione"/><br>';
                          if($prestazione!=NULL && $prestazione["espulsioneSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'espulsione".$k."','ammonizione".$k."')".'" name="espulsioneSN" id="espulsione'.$k.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'espulsione".$k."','ammonizione".$k."')".'" name="espulsioneSN" id="espulsione'.$k.'">';
                          }
                        echo '</div>';
                      echo '</div><div class="row">';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal decisivo pareggio"].'" alt="goal_decisivo_pareggio"/><br>';
                          if($prestazione!=NULL && $prestazione["goal_decisivo_pareggioSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_pareggio".$k."','goal_decisivo_vittoria".$k."')".'" name="goal_decisivo_pareggioSN" id="goal_decisivo_pareggio'.$k.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_pareggio".$k."','goal_decisivo_vittoria".$k."')".'" name="goal_decisivo_pareggioSN" id="goal_decisivo_pareggio'.$k.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal decisivo vittoria"].'" alt="goal_decisivo_vittoria"/><br>';
                          if($prestazione!=NULL && $prestazione["goal_decisivo_vittoriaSN"]=='S'){
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_vittoria".$k."','goal_decisivo_pareggio".$k."')".'" name="goal_decisivo_vittoriaSN" id="goal_decisivo_vittoria'.$k.'" checked>';
                          } else {
                            echo '<input type="checkbox" onclick="controllaSelezione('."'goal_decisivo_vittoria".$k."','goal_decisivo_pareggio".$k."')".'" name="goal_decisivo_vittoriaSN" id="goal_decisivo_vittoria'.$k.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["autogol"].'" alt="autogol"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="autogol" min="0" value="'.$prestazione["autogol"].'">';
                          } else {
                            echo '<input type="number" name="autogol" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["goal subito"].'" alt="goal_subito"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="goal_subiti" min="0" value="'.$prestazione["goal_subiti"].'">';
                          } else {
                            echo '<input type="number" name="goal_subiti" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["rigore parato"].'" alt="rigore_parato"/><br>';
                          if($prestazione!=NULL){
                            echo '<input type="number" name="rigori_parati" min="0" value="'.$prestazione["rigori_parati"].'">';
                          } else {
                            echo '<input type="number" name="rigori_parati" min="0" value="0">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["entrato"].'" alt="entrato"/><br>';
                          if($prestazione!=NULL && $prestazione["entratoSN"]=='S'){
                            echo '<input type="checkbox" name="entratoSN" id="entrato'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" name="entratoSN" id="entrato'.$i.'">';
                          }
                        echo '</div>';
                        echo '<div class="col">';
                          echo '<img class="bonus" src="data:image/jpeg;base64,'.$immagini_bonus["uscito"].'" alt="uscito"/><br>';
                          if($prestazione!=NULL && $prestazione["uscitoSN"]=='S'){
                            echo '<input type="checkbox" name="uscitoSN" id="uscito'.$i.'" checked>';
                          } else {
                            echo '<input type="checkbox" name="uscitoSN" id="uscito'.$i.'">';
                          }
                        echo '</div>';
                      echo '</div>';
                    if($prestazione==NULL){
                      echo '<br><div class="row justify-content-start"><button type="submit" class="btn btn-primary">Inserisci prestazione</button></div></form></div>';
                    } else {
                      echo '<br><div class="row justify-content-between">';
                        echo '<div class="col-sm-4"><div class="row justify-content-start"><button type="submit" class="btn btn-warning">Modifica prestazione</button></div></div>';
                        echo '<div class="col-sm-4"><div class="row justify-content-end"><a href="./EliminaPrestazione.php?id_calciatore='.$calciatori_trasferta[$i]["id_calciatore"].'&numero_giornata='.$_GET["numero_giornata"].'&id_squadra_SerieA_casa='.$_GET["id_squadra_SerieA_casa"].'&id_squadra_SerieA_trasferta='.$_GET["id_squadra_SerieA_trasferta"].'" class="btn btn-danger">Elimina prestazione</button></div></div>';
                      echo '</div></form></div>';
                    }
                  echo '</td>';
                } else {
                  echo '<td></td>';
                }
                echo '</tr>';
              }
          ?>
        </tbody>
      </table>
      

  </body>


</html>