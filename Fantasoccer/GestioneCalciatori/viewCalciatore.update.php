<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}

if(isset($_GET["id_calciatore"]) && !empty($_GET["id_calciatore"])){
    $calciatore=Fantacalcio::getCalciatore($_GET["id_calciatore"]);
    if($calciatore==NULL){
        header("Location: ./index.php?error=2"); die;
    }
}
?>



<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Gestioni.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="../popper-1.15.0/js/popper.min.js"></script>
    <script src="../bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script src="../js/Gestioni.js"></script>
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
                    echo 'Mancano i dati necessari per poter modificare le informazioni riguardanti il calciatore.';
                  } else if($_GET['error']==2){
                    echo 'Manca il nome del calciatore.';
                  } else if($_GET['error']==3){
                    echo 'Manca il cognome del calciatore.';
                  } else if($_GET['error']==4){
                    echo 'Manca il ruolo del calciatore.';
                  } else if($_GET['error']==5){
                    echo 'Manca la squadra a cui appartiene il calciatore.';
                  } else if($_GET['error']==6){
                    echo 'Manca il valore del calciatore.';
                  } else if($_GET['error']==7){
                    echo 'Manca il tipo di infortunio del calciatore.';
                  } else if($_GET['error']==8){
                    echo 'Manca l\'informazione sul fatto che il calciatore sia squalificato o meno.';
                  } else if($_GET['error']==9){
                    echo 'Manca l\'informazione sul fatto che il calciatore sia stato venduto all\'estero o meno.';
                  } else if($_GET['error']==10){
                    echo 'Manca la probabilità di giocare del calciatore.';
                  } else {
                    echo 'Per un qualche motivo è stato impossibile modificare il calciatore';
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

    <div class="container">
        <div class="fixed-top">
            <nav class="navbar navbar-light bg-info">
                <a class="navbar-brand" href="#">GESTIONE CALCIATORI</a>
            </nav>
        </div>
        <div style="margin-top:100px">

        <form method="POST" action="./updateCalciatore.php">
        <input type="number" name="id_calciatore" <?php echo('value="'.$_GET["id_calciatore"].'"') ?> hidden>
            <div class="form-group">
                <label for="inputFirstName">Nome</label>
                <input type="text" class="form-control" id="inputNome" name="nome" <?php echo('value="'.$calciatore["nome"].'"') ?>>
            </div>
            <div class="form-group">
                <label for="inputLastName">Cognome</label>
                <input type="text" class="form-control" id="inputCognome" name="cognome" <?php echo('value="'.$calciatore["cognome"].'"') ?>>
            </div>  

            <div class="form-group">
                <label for="inputRuolo">Ruolo</label>
                <select class="form-control" id="inputRuolo" name="ruolo">
                    <option <?php if($calciatore["ruolo"]=="Portiere"){echo('selected');}?>>Portiere</option>
                    <option <?php if($calciatore["ruolo"]=="Difensore"){echo('selected');}?>>Difensore</option>
                    <option <?php if($calciatore["ruolo"]=="Centrocampista"){echo('selected');}?>>Centrocampista</option>
                    <option <?php if($calciatore["ruolo"]=="Attaccante"){echo('selected');}?>>Attaccante</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inputSquadra">Squadra</label>
                <select class="form-control" id="inputSquadra" name="id_squadra_serieA">
                    <?php
                        $list = Fantacalcio::getSquadre();
                        if (!(is_null($list)))  {
                            foreach ($list as $squadra) {
                                echo '<option value="'.$squadra["id"].'"';
                                if($calciatore["id_squadra_serieA"]==$squadra["id"]){echo('selected');}
                                echo '>'.ucwords($squadra["nome"]).'</option>';
                            }//tofix
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="inputValore">Valore</label>
                <input type="number" class="form-control" id="inputValore" name="valore" min="1" <?php echo('value="'.$calciatore["valore"].'"') ?>>
            </div>
            <div class="form-group">
                <label for="inputInfortunio">Tipo di infortunio</label>
                <select class="form-control" id="inputInfortunio" name="infortunatoSCN">
                    <option value="N" <?php if($calciatore["infortunatoSCN"]=="N"){echo('selected');}?>>Nessuno</option>
                    <option value="C" <?php if($calciatore["infortunatoSCN"]=="C"){echo('selected');}?>>Covid</option>
                    <option value="S" <?php if($calciatore["infortunatoSCN"]=="S"){echo('selected');}?>>Muscolare</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputSqualifica">Squalificato</label>
                <select class="form-control" id="inputSqualifica" name="squalificatoSN">
                    <option value="N" <?php if($calciatore["squalificatoSN"]=="N"){echo('selected');}?>>No</option>
                    <option value="S" <?php if($calciatore["squalificatoSN"]=="S"){echo('selected');}?>>Si</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputEstero">Venduto all'estero</label>
                <select class="form-control" id="inputEstero" name="esteroSN">
                    <option value="N" <?php if($calciatore["esteroSN"]=="N"){echo('selected');}?>>No</option>
                    <option value="S" <?php if($calciatore["esteroSN"]=="S"){echo('selected');}?>>Si</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputProb_giocare">Probabilità di giocare</label>
                <input type="range" class="form-range" min="0" max="100" step="5" oninput="updateTextInput(this.value);" onchange="updateTextInput(this.value);" name="prob_giocare" id="inputProb_giocare" <?php echo('value='.$calciatore["prob_giocare"]) ?>>
                <div class="d-flex justify-content-center"><input class="percentage" type="text" id="textInput" <?php echo('value="'.$calciatore["prob_giocare"].'%"') ?> readonly></div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="./index.php" class="btn btn-info">Cancel</a>
        </form>
        <br><br>
    </div>

</body>

</html>



