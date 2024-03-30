<?php
require_once('Fantacalcio.php');
session_start();

if(empty($_SESSION["id_pagellista"])){
  header("Location: ./login.php?type=Pagellista");die;
}

if(!empty($_GET['numero_giornata'])){
  if($_GET['numero_giornata']<0 || $_GET['numero_giornata']>Fantacalcio::getNumeroGiornate()){
    header("Location: ./AreaPagellista.php?error=38");die;
  }
}
?>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/AreaPagellista.css">
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
                    echo 'Mancano i dati necessari per poter entrare nella zona dove inserire i voti ai calciatori di una determinata partita.';
                  } else if($_GET['error']==2){
                    echo 'Manca il numero della giornata, il quale è indispensabile per poter entrare nella zona dove inserire i voti ai calciatori.';
                  } else if($_GET['error']==3){
                    echo 'Manca l\'id della squadra di casa, il quale è indispensabile per poter entrare nella zona dove inserire i voti ai calciatori.';
                  } else if($_GET['error']==4){
                    echo 'Manca l\'id della squadra in trasferta, il quale è indispensabile per poter entrare nella zona dove inserire i voti ai calciatori.';
                  } else if($_GET['error']==5){
                    echo 'Manca il numero della giornata, il quale è indispensabile per poter eliminare la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==6){
                    echo 'Manca l\'id del calciatore, il quale è indispensabile per poter eliminare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==7){
                    echo 'La prestazione del calciatore è stata eliminata con successo. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==8){
                    echo 'Per un qualche motivo non è stato possibile eliminare la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==9){
                    echo 'Manca il numero della giornata, il quale è indispensabile per poter inserire la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==10){
                    echo 'Mancano i dati necessari per poter inserire la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==11){
                    echo 'Manca l\'id del calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==12){
                    echo 'Manca il voto del calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==13){
                    echo 'Manca il numero di goal su azione del calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==14){
                    echo 'Manca il numero di goal su rigore del calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==15){
                    echo 'Manca il numero di rigori sbagliati dal calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==16){
                    echo 'Manca il numero di assist del calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==17){
                    echo 'Manca il numero di autogol del calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==18){
                    echo 'Manca il numero di goal subiti dal calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==19){
                    echo 'Manca il numero di rigori parati dal calciatore, il quale è indispensabile per poter inserire la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==20){
                    echo 'Non è stato possibile inserire la prestazione perchè il calciatore non può aver fatto un goal decisivo se non ha nemmeno segnato. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==21){
                    echo 'La prestazione del calciatore è stata inserita con successo. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==22){
                    echo 'Per un qualche motivo non è stato possibile inserire la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==23){
                    echo 'Manca il numero della giornata, il quale è indispensabile per poter modificare la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==24){
                    echo 'Mancano i dati necessari per poter modificare la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==25){
                    echo 'Manca l\'id del calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==26){
                    echo 'Manca il voto del calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==27){
                    echo 'Manca il numero di goal su azione del calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==28){
                    echo 'Manca il numero di goal su rigore del calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==29){
                    echo 'Manca il numero di rigori sbagliati dal calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==30){
                    echo 'Manca il numero di assist del calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==31){
                    echo 'Manca il numero di autogol del calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==32){
                    echo 'Manca il numero di goal subiti dal calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==33){
                    echo 'Manca il numero di rigori parati dal calciatore, il quale è indispensabile per poter modificare la sua prestazione. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==34){
                    echo 'Non è stato possibile modificare la prestazione perchè il calciatore non può aver fatto un goal decisivo se non ha nemmeno segnato. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==35){
                    echo 'La prestazione del calciatore è stata modificata con successo. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==36){
                    echo 'Per un qualche motivo non è stato possibile modificare la prestazione del calciatore. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==37){
                    echo 'La partita che stavi cercando non esiste. <br>Sei stato reinderizzato alla pagina principale per via della mancanza dei dati necessari ad individuare una partita.';
                  } else if($_GET['error']==38){
                    echo 'La giornata che stavi cercando non esiste.';
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
    
    <div class="header">
      <div class="d-flex align-items-center title"><h1>AREA PAGELLISTA</h1></div>
      <div class="logoutButton"><a class="btn btn-warning mt-3 mb-3 float-right" href="./logout.php?type=id_pagellista">Logout</a></div>
    </div>
    

    <div class="row">
      <div class="vertical-menu">
        <?php
        echo '<a ' . (empty($_GET['numero_giornata'])? 'class="active"' : '') . ' href="AreaPagellista.php">Giornata corrente/Ultima giornata</a>';
        for ($i = 1; $i < 39; $i++) {
          echo ('<a ' . ((!empty($_GET['numero_giornata']) && $_GET['numero_giornata']==$i)? 'class="active"' : '') . ' href="AreaPagellista.php?numero_giornata='.$i.'">Giornata ' . $i . '</a>');
        }
        ?>
      </div>
      <div class="partite">
        <?php
          if(isset($_GET["numero_giornata"])){
            $numero_giornata=$_GET["numero_giornata"];
          } else {
            $numero_giornata=Fantacalcio::getNumeroLastGiornata();
          }
          $partite=Fantacalcio::getPartiteGiornata($numero_giornata);
          echo '<div class="list-group">';
          foreach($partite as $partita){
            if($partita["rinviataSN"]=='S'){
              if($partita["data_ora_inizio"]==NULL){
                echo '<a class="list-group-item d-flex list-group-item-dark justify-content-between align-items-center">';
                if($partita["stemma_casa"]==NULL){
                  echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
                } else {
                  echo '<img src="data:image/jpeg;base64,'.$partita["stemma_casa"].'" alt="stemma_'.$partita["nome_casa"].'"/>';
                }
                echo '<h1>'.$partita["nome_casa"].'-'.$partita["nome_trasferta"].'</h1>';
                if($partita["stemma_trasferta"]==NULL){
                  echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
                } else {
                  echo '<img src="data:image/jpeg;base64,'.$partita["stemma_trasferta"].'" alt="stemma_'.$partita["nome_trasferta"].'"/>';
                }
                echo '<span class="badge badge-danger badge-pill">Partita rinviata a data da definirsi</span></a>';
              } else {
                if(new DateTime($partita["data_ora_inizio"])<=new DateTime(date('Y-m-d H:i:s'))){ //con new DateTime(date('Y-m-d H:i:s') ottengo la data e ora del computer seguendo il formato Y-m-d H:i:s. Questo è stato fatto per scopo dimostrativo, difatti nell'applicazione reale andrebbero messe la data e ora effettive e non quelle del pc!
                  echo '<a class="list-group-item d-flex list-group-item-action justify-content-between align-items-center" href="./VotiPartita.php?numero_giornata='.$numero_giornata.'&id_squadra_SerieA_casa='.$partita["id_squadra_SerieA_casa"].'&id_squadra_SerieA_trasferta='.$partita["id_squadra_SerieA_trasferta"].'">';
                } else {
                  echo '<a class="list-group-item d-flex list-group-item-dark justify-content-between align-items-center">';
                }
                if($partita["stemma_casa"]==NULL){
                  echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
                } else {
                  echo '<img src="data:image/jpeg;base64,'.$partita["stemma_casa"].'" alt="stemma_'.$partita["nome_casa"].'"/>';
                }
                echo '<h1>'.$partita["nome_casa"].'-'.$partita["nome_trasferta"].'</h1>';
                if($partita["stemma_trasferta"]==NULL){
                  echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
                } else {
                  echo '<img src="data:image/jpeg;base64,'.$partita["stemma_trasferta"].'" alt="stemma_'.$partita["nome_trasferta"].'"/>';
                }
                echo '<span class="badge badge-warning badge-pill">Partita rinviata in data: '.$partita["data_ora_inizio"].'</span></a>';
              }
            } else {
              if(new DateTime($partita["data_ora_inizio"])<=new DateTime(date('Y-m-d H:i:s'))){ //con new DateTime(date('Y-m-d H:i:s') ottengo la data e ora del computer seguendo il formato Y-m-d H:i:s. Questo è stato fatto per scopo dimostrativo, difatti nell'applicazione reale andrebbero messe la data e ora effettive e non quelle del pc!
                echo '<a class="list-group-item d-flex list-group-item-action justify-content-between align-items-center" href="./VotiPartita.php?numero_giornata='.$numero_giornata.'&id_squadra_SerieA_casa='.$partita["id_squadra_SerieA_casa"].'&id_squadra_SerieA_trasferta='.$partita["id_squadra_SerieA_trasferta"].'">';
              } else {
                echo '<a class="list-group-item d-flex list-group-item-dark justify-content-between align-items-center">';
              }
              if($partita["stemma_casa"]==NULL){
                echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
              } else {
                echo '<img src="data:image/jpeg;base64,'.$partita["stemma_casa"].'" alt="stemma_'.$partita["nome_casa"].'"/>';
              }
              echo '<h1>'.$partita["nome_casa"].'-'.$partita["nome_trasferta"].'</h1>';
              if($partita["stemma_trasferta"]==NULL){
                echo '<img src="./images/Default/NoImage.png" alt="NoImage"/>';
              } else {
                echo '<img src="data:image/jpeg;base64,'.$partita["stemma_trasferta"].'" alt="stemma_'.$partita["nome_trasferta"].'"/>';
              }
              echo '<span class="badge badge-primary badge-pill">'.$partita["data_ora_inizio"].'</span></a>';
            }
          } 
          echo '</ul><br>';
        ?>
      </div>
    </div>
  </body>


</html>