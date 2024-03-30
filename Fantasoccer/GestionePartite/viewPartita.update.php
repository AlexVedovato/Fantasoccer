<?php
require_once('../Fantacalcio.php');
session_start();

if (empty($_SESSION["id_admin"])) {
  header("Location: ../login.php?type=Admin");
  die;
}

if (
  isset($_GET["numero_giornata"]) && isset($_GET["id_squadra_serieA_casa"]) && isset($_GET["id_squadra_serieA_trasferta"]) &&
  !empty($_GET["numero_giornata"]) && !empty($_GET["id_squadra_serieA_casa"]) && !empty($_GET["id_squadra_serieA_trasferta"])
) {
  $partita = Fantacalcio::getPartitaSerieA($_GET["numero_giornata"], $_GET["id_squadra_serieA_casa"], $_GET["id_squadra_serieA_trasferta"]);
  if ($partita == NULL) {
    header("Location: ./index.php?error=2");
    die;
  }
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
  if (isset($_GET['error'])) {
  ?>
    <!-- Modal -->
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
            if ($_GET['error'] == 1) {
              echo 'Mancano i dati necessari per inserire la partita.';
            } else if ($_GET['error'] == 2) {
              echo 'Manca la data e l\' ora d\' inizio.';
            } else if ($_GET['error'] == 3) {
              echo 'Manca il numero della giornata.';
            } else if ($_GET['error'] == 4) {
              echo 'Manca la specifica se la partita è stata rinviata.';
            } else if ($_GET['error'] == 5) {
              echo 'Manca la squadra di casa.';
            } else if ($_GET['error'] == 6) {
              echo 'Manca la squadra ospite.';
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



      <form method="POST" action="./updatePartita.php">

        <div class="form-group">
          <label for="inputDataOra">Data e ora d' inizio</label>
          <input type="datetime-local" class="form-control" id="dataOraInizio" name="dataOraInizio" <?php echo ('value=' . str_replace(' ', 'T', $partita["data_ora_inizio"])) ?>>
        </div>

        <div class="form-group">
          <label for="inputNumeroGiornata">Numero giornata</label>
          <input type="number" class="form-control" id="numeroGiornata" name="numero_giornata" min="1" <?php echo ('value=' . $partita["numero_giornata"]) ?> readonly>
        </div>

        <div class="form-group">
          <label for="inputRinviata">Rinviata</label>
          <select class="form-control" id="rinviata" name="rinviata">
            <option value="S" <?php if ($partita["rinviataSN"] == "S") {
                                echo ('selected');
                              } ?>>SI</option>
            <option value="N" <?php if ($partita["rinviataSN"] == "N") {
                                echo ('selected');
                              } ?>>NO</option>
          </select>
        </div>

        <div class="form-group">
          <label for="inputSquadraCasa">Squadra di casa</label>

          <input type="text" class="form-control" name="id_squadra_serieA_casa" <?php echo('value='.$partita["id_squadra_serieA_casa"]) ?> hidden>
            <?php
            $squadra = Fantacalcio::getNomeStemmaSquadra($partita["id_squadra_serieA_casa"]);
            echo'<input type="text" class="form-control" id="input_id_squadra_serieA_casa" value="'.ucwords($squadra["nome"]).'" readonly >';
            ?>
        </div>

        <div class="form-group">
          <label for="inputHireDate">Squadra ospite</label>
          <input type="text" class="form-control" name="id_squadra_serieA_trasferta" <?php echo('value='.$partita["id_squadra_serieA_trasferta"]) ?> hidden>
            <?php
            $squadra = Fantacalcio::getNomeStemmaSquadra($partita["id_squadra_serieA_trasferta"]);
            echo'<input type="text" class="form-control" id="input_id_squadra_serieA_trasferta" value="'.ucwords($squadra["nome"]).'" readonly >';
            ?>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="./index.php" class="btn btn-info">Cancel</a>
      </form>
      <br><br><br><br>





</body>

</html>