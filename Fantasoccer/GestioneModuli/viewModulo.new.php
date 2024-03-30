<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
    header("Location: ../login.php?type=Admin");die;
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
                    echo 'Mancano i dati necessari per poter inserire il nuovo modulo.';
                  } else if($_GET['error']==2){
                    echo 'Manca il numero di difensori.';
                  } else if($_GET['error']==3){
                    echo 'Manca il numero di centrocampisti.';
                  } else if($_GET['error']==4){
                    echo 'Manca il numero di attaccanti.';
                  } else if($_GET['error']==5){
                    echo 'Il numero di calciatori è maggiore di 10.';
                  } else if($_GET['error']==6){
                    echo 'Il numero di calciatori è minore di 10.';
                  } else if($_GET['error']==7){
                    echo 'Esiste già un modulo con questo numero di difensori, centrocampisti e attaccanti.';
                  } else {
                    echo 'Per un qualche motivo è stato impossibile inserire il nuovo modulo.';
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
                <a class="navbar-brand" href="#">VIEW MODULO</a>
            </nav>
        </div>
        <div style="margin-top:100px">

        <form method="POST" action="./insertModulo.php">
            <div class="form-group">
                <label for="inputNumDifensori">Numero Difensori</label>
                <input type="number" min="0" class="form-control" id="inputNumDifensori" name="numeroDifensori" value="1" >
            </div>
            <div class="form-group">
                <label for="inputNumCentrocampisti">Numero Centrocampisti</label>
                <input type="number" min="0" class="form-control" id="inputLastName" name="numeroCentrocampisti" value="1">
            </div>

            <div class="form-group">
                <label for="inputNumAttaccanti">Numero Attaccanti</label>
                <input type="number" min="0" class="form-control" id="inputNumAttaccanti" name="numeroAttaccanti" value="1">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="./index.php" class="btn btn-info">Cancel</a>
        </form>
        <br><br>
    </div>
</body>
</html>



