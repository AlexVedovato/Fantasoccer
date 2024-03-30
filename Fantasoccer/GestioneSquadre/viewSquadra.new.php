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
                    echo 'Mancano i dati necessari per poter inserire la nuova squadra.';
                  } else if($_GET['error']==2){
                    echo 'Manca il nome della squadra.';
                  } else if($_GET['error']==3){
                    echo 'Formato del file non accettabile.';
                  } else if($_GET['error']==4){
                    echo 'Esiste già una squadra con questo nome.';
                  } else {
                    echo 'Per un qualche motivo è stato impossibile inserire la nuova squadra';
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
                <a class="navbar-brand" href="#">GESTIONE SQUADRE SERIE A</a>
            </nav>
        </div>
        <div style="margin-top:100px">

        <form method="POST" action="./insertSquadra.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="inputFirstName">Nome</label>
                <input type="text" class="form-control" id="inputNome"name="nome">
            </div>
            <div class="form-group">
                <label for="inputStemma">Stemma</label>
                <div id="drop_file_zone" ondrop="set_file(event)" ondragover="return false">
                  <div id="drag_upload_file">
                    <br>
                    <p>Lascia il file qui</p>
                    <p>oppure</p>
                    <p><input type="file" name="image" id="selectfile"></p>
                  </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="./index.php" class="btn btn-info">Cancel</a>
        </form>
        <br><br>
    </div>

</body>

</html>



