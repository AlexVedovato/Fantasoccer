<?php
    require_once('./Fantacalcio.php');
    session_start();
    if(empty($_SESSION["id_fantallenatore"])){
        header("Location: ./login.php");die;
    }
    if(empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])){
        header("Location: ./SelezionaLega.php");die;
    }

    $regolamento=Fantacalcio::getRegolamento($_SESSION["id_fantalega"]);
    $idModuliConsentiti=Fantacalcio::getIdModuliConsentiti($_SESSION["id_fantalega"]);
    $valoriBonus=Fantacalcio::getValoriBonus($_SESSION["id_fantalega"]);
?>

<html>

<head>

  <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./css/CreaLega.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    echo 'Non puoi modificare il regolamento se non sei amministratore di lega.';
                  } else if($_GET['error']==2){
                    echo 'Manca l\' id della fantalega.';
                  } else if($_GET['error']==3){
                    echo 'Manca il numero di crediti iniziali per le squadre della fantalega.';
                  } else if($_GET['error']==4){
                    echo 'Manca il numero di portieri per ogni fantasquadra.';
                  } else if($_GET['error']==5){
                    echo 'Manca il numero di difensori per ogni fantasquadra.';
                  } else if($_GET['error']==6){
                    echo 'Manca il numero di centrocampisti per ogni fantasquadra.';
                  } else if($_GET['error']==7){
                    echo 'Manca il numero di attaccanti per ogni fantasquadra.';
                  } else if($_GET['error']==8){
                    echo 'Manca il voto da assegnare ai giocatori senza voto che vengono ammoniti.';
                  } else if($_GET['error']==9){
                    echo 'Manca il termine ultimo per la consegna della formazione(in minuti).';
                  } else if($_GET['error']==10){
                    echo 'Manca il punteggio da assegnare alla fantasquadra che non ha inserito la formazione.';
                  } else if($_GET['error']==11){
                    echo 'Manca il punteggio necessario da fare in più per ottenere un goal successivo al primo(il quale si ottiene a 66 punti).';
                  } else if($_GET['error']==12){
                    echo 'Deve essere consentito almeno un modulo.';
                  } else if($_GET['error']==13){
                    echo 'Deve inserire il valore corrispondente ad ogni bonus.';
                  } else if($_GET['error']==14){
                    echo 'Abbiamo avuto un problema nell\'associare i bonus al valore che tu gli hai dato. Ci scusiamo per l\'accaduto e speriamo non accada di nuovo.';
                  } else if($_GET['error']==15){
                    echo 'Purtroppo non è stato possibile modificare il regolamento della lega.';
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
 <?php include("./Navbar.php"); ?>
 <div class="box container">
  
  <h1 class="text-center">Regolamento</h1>

  <form method="POST" action="./updateRegolamento.php">

  <input type="number" value="<?php echo($_SESSION["id_fantalega"])?>" name="id_fantalega" hidden>

    <div class="form-group">
        <label for="inputCrediti">Numero di crediti iniziali di ogni squadra nella lega</label>
        <input type="number" class="form-control" min="0" max="2000" value="<?php echo($regolamento["crediti_iniziali"]) ?>" id="inputCrediti" name="crediti_iniziali" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
    </div>

    <label for="inputRuoli">Numero di giocatori per ogni ruolo nella lega</label>
    <div class="form-group text-center" id="inputRuoli">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" >Portieri</label>
          <div class="col-sm-1">
              <input type="number" class="form-control" value="<?php echo($regolamento["numero_portieri"]) ?>" min="2" max="3" name="numero_portieri" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
          </div>
          <label class="col-sm-2 col-form-label" >Difensori</label>
          <div class="col-sm-1">
              <input type="number" class="form-control" value="<?php echo($regolamento["numero_difensori"]) ?>" min="6" max="8" name="numero_difensori" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
          </div>
          <label class="col-sm-2 col-form-label" >Centrocampisti</label>
          <div class="col-sm-1">
              <input type="number" class="form-control" value="<?php echo($regolamento["numero_centrocampisti"]) ?>" min="6" max="8" name="numero_centrocampisti" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
          </div>
          <label class="col-sm-2 col-form-label" >Attaccanti</label>
          <div class="col-sm-1">
              <input type="number" class="form-control" value="<?php echo($regolamento["numero_attaccanti"]) ?>" min="6" max="8" name="numero_attaccanti" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
          </div>
      </div>
    </div>

    <div class="form-group">
        <label for="inputVotoAmmonitoSV">Voto da assegnare ai giocatori senza voto che vengono ammoniti</label>
            <?php 
              if($_SESSION["amministratoreSN"]=='N'){
                echo '<input type="number" class="form-control" value="'.$regolamento["voto_ammonito_sv"].'" name="voto_ammonito_sv" '.($_SESSION["amministratoreSN"]=='N'?"readonly":"").'>';
              } else {
                ?>
                <select class="form-control" id="inputSquadraVotoAmmonitoSV" name="voto_ammonito_sv">
                <option value="-1" <?php if($regolamento["voto_ammonito_sv"]==-1){echo("selected");} ?>>SV</option>
                <?php
                for($j=4.5;$j<6;$j+=0.5){
                  echo '<option '.($regolamento["voto_ammonito_sv"]==$j?"selected>":">").$j.'</option>'; 
                }
                echo '</select>';
              }
            ?>
    </div>

    <div class="form-group">
        <label for="inputTempoTermineFormazione">Termine ultimo per la consegna della formazione(in minuti)</label>
        <input type="number" class="form-control" min="5" max="60" value="<?php echo($regolamento["tempo_termine_formazione"]) ?>" id="inputTempoTermineFormazione" name="tempo_termine_formazione" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
    </div>

    <div class="form-group">
        <label for="inputPunteggioFormazioneSchierataN">Punteggio da assegnare alla fantasquadra che non ha inserito la formazione</label>
        <input type="number" class="form-control" min="0" max="65" value="<?php echo($regolamento["punteggio_formazione_schierataN"]) ?>" id="inputPunteggioFormazioneSchierataN" name="punteggio_formazione_schierataN" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
    </div>

    <div class="form-group">
        <label for="inputSogliaGoal">Punteggio necessario da fare in più per ottenere un goal successivo al primo(il quale si ottiene a 66 punti)</label>
        <input type="number" class="form-control" min="2" max="8" value="<?php echo($regolamento["soglia_goal"]) ?>" id="inputSogliaGoal" name="soglia_goal" <?php if($_SESSION["amministratoreSN"]=='N'){echo("readonly");}?>>
    </div>

    <h2>Moduli consentiti</h2>
    <div class="form-group text-center">
        <?php
            $list = Fantacalcio::getListaModuli();
            if (!(is_null($list)))  {
                foreach ($list as $modulo) {
                    echo '<div class="row"><div class="col align-self-center">';
                        echo '<label>'.$modulo["numero_difensori"].$modulo["numero_centrocampisti"].$modulo["numero_attaccanti"].'</label>';
                    echo '</div><div class="col align-self-center">';
                        echo '<input type="checkbox" name="moduli[]" value="'.$modulo["id_modulo"].'" '.(in_array($modulo["id_modulo"],$idModuliConsentiti)?"checked":"").' '.($_SESSION["amministratoreSN"]=='N'?"onclick='return false;'":"").'>';
                    echo '</div></div>';
                }
            }
        ?>
    </div>

    <h2>Valore dei bonus</h2>
    <div class="form-group text-center">
        <?php
            $list = Fantacalcio::getListaBonus();
            if (!(is_null($list)))  {
                foreach ($list as $bonus) {
                    if($bonus["valore_default"]!=0){
                        echo '<div class="row"><div class="col align-self-center">';
                            echo '<label>'.ucwords($bonus["descrizione"]).'</label>';
                        echo '</div><div class="col align-self-center">';
                            echo '<img src="data:image/jpeg;base64,'.$bonus["immagine"].'"/>';
                        echo '</div><div class="col">';
                            echo '<input type="number" class="form-control text-center" value="'.((array_key_exists($bonus["id_bonus"],$valoriBonus))?$valoriBonus[$bonus["id_bonus"]]:$bonus["valore_default"]).'" step="0.5" id="inputValoreBonus" name="valoriBonus[]" '.($_SESSION["amministratoreSN"]=='N'?"readonly":"").'>';
                            echo '<input type="number" value="'.$bonus["id_bonus"].'" id="inputIDBonus" name="id_bonus[]" hidden>';
                        echo '</div></div>';
                    }
                }
            }
        ?>
    </div>

    <div class="row">
        <?php
          if($_SESSION["amministratoreSN"]=='S'){
            echo('<div class="col-6"><div class="row d-flex justify-content-between"></div><button style="margin-left:auto" type="submit" class="btn btn-primary">Aggiorna regolamento</button></div>');
          }
        ?>
    </div>
</form>
  
 </div>


</body>
</html>