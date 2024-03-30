<?php
require_once('../Fantacalcio.php');
session_start();

if (empty($_SESSION["id_admin"])) {
    header("Location: ../login.php?type=Admin");
    die;
}


?>



<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../bootstrap-4.3.1/css/bootstrap.min.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="../popper-1.15.0/js/popper.min.js"></script>
    <script src="../bootstrap-4.3.1/js/bootstrap.min.js"></script>

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
                    echo 'Mancano i dati necessari per inserire la partita.';
                  } else if($_GET['error']==2){
                    echo 'Manca la data e l\' ora d\' inizio.';
                  } else if($_GET['error']==3){
                    echo 'Manca il numero della giornata.';
                  } else if($_GET['error']==4){
                    echo 'Manca la specifica se la partita è stata rinviata.';
                  } else if($_GET['error']==5){
                    echo 'Manca la squadra di casa.';
                  } else if($_GET['error']==6){
                    echo 'Manca la squadra ospite.';
                  } else if($_GET['error']==7){
                    echo 'Le 2 squadre non possono essere uguali.';
                  } else if($_GET['error']==8){
                    echo 'La squadra di casa precedentemente selezionata ha già un impegno nella giornata indicata.';
                  } else if($_GET['error']==9){
                    echo 'La squadra in trasferta precedentemente selezionata ha già un impegno nella giornata indicata.';
                  } else {
                    echo 'Per un qualche motivo è stato impossibile inserire la partita';
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
                <a class="navbar-brand" href="#">GESTIONE PARTITE</a>
            </nav>
        </div>
        <div style="margin-top:100px">



            <form method="POST" action="./insertPartita.php">
                <div class="form-group">
                    <label for="inputDataOra">Data e ora d' inizio</label>
                    <input type="datetime-local" class="form-control" id="dataOraInizio" placeholder="Data e ora d' inizio" name="dataOraInizio">
                </div>

                <div class="form-group">
                    <label for="inputNumeroGiornata">Numero giornata</label>
                    <input type="number" class="form-control" id="numeroGiornata" placeholder="Numero giornata" name="numeroGiornata" value="1" min="1" max="38">
                </div>

                <div class="form-group">
                    <label for="inputRinviata">Rinviata</label>
                    <select class="form-control" id="rinviata" name="rinviata">
                        <option value="S">SI</option>
                        <option value="N" selected="selected">NO</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputSquadraCasa">Squadra di casa</label>
                    <select class="form-control" id="inputSquadraCasa" name="id_squadra_serieA_casa">
                        <?php
                        $list = Fantacalcio::getSquadre();
                        var_dump($list);
                        if (!(is_null($list))) {
                            foreach ($list as $squadra) {
                                echo '<option value="' . $squadra["id"] . '">' . ucwords($squadra["nome"]) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputHireDate">Squadra ospite</label>
                    <select class="form-control" id="inputSquadraOspite" name="id_squadra_serieA_ospite">
                        <?php
                        $list = Fantacalcio::getSquadre();
                        var_dump($list);
                        if (!(is_null($list))) {
                            foreach ($list as $squadra) {
                                echo '<option value="' . $squadra["id"] . '">' . ucwords($squadra["nome"]) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="./index.php" class="btn btn-info">Cancel</a>
            </form>
            <br><br><br><br>





</body>

</html>