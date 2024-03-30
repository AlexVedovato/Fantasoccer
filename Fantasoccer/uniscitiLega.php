<?php
require_once('Fantacalcio.php');
session_start();

if(empty($_SESSION["id_fantallenatore"])){
  header("Location: ./login.php");die;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/UniscitiLega.css">
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
                        echo 'La competizione in questa lega è già stata avviata, ciò significa che non potrai unirti a quest\'ultima fino a quando la competizione non sarà terminata.';
                      } else if($_GET['error']==2){
                        echo 'A quanto pare sei già un partecipante di questa lega.';
                      } else if($_GET['error']==3){
                        echo 'Mancano i dati per potersi unire ad una lega.';
                      } else if($_GET['error']==4){
                        echo 'Manca il nome della lega.';
                      } else if($_GET['error']==5){
                        echo 'Manca la parola d\'ordine.';
                      } else if($_GET['error']==6){
                        echo 'Non troviamo la lega che stai cercando, ricontrolla e reinserisci il nome e la parola d\'ordine.';
                      } else {
                        echo 'Per un qualche motivo è stato impossibile farti unire alla lega.';
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
        <div class="wrapper">
          <div class="row">
            <div class="col">
              <div class="wrapper">
                <div id="formContent" <?php if(empty($_POST) && empty($_GET)){echo 'class="fadeIn first"';}?>>
                  <form action="./UniscitiLega.php" method="POST">
                    <h2>Scrivi il nome della lega</h2>
                    <input type="text" id="nomeLega" name="nomeLega" <?php if(!empty($_POST)){echo 'value="'.$_POST["nomeLega"].'"';}?>>
                    <h2>Scrivi la parola d'ordine</h2>
                    <input type="text" id="parolaOrdine" name="parolaOrdine" <?php if(!empty($_POST)){echo 'value="'.$_POST["parolaOrdine"].'"';}?>>
                        <br>
                        <br>
                    <input type="submit" value="Verifica la parola d'ordine">
                  </form>
                </div>
              </div>
            </div>
            <div class="col">
              <?php
                if(!empty($_POST)){
                  require_once('Fantacalcio.php');
                  $result=Fantacalcio::checkLega($_POST["nomeLega"],$_POST["parolaOrdine"]); 
                  if($result!=NULL){
                    echo '<div class="container fadeIn first">';
                      echo '<div class="col">';
                        if($result['logo']!=NULL){
                          echo '<div class="text-center"><img height="150" width="150" src="data:image/jpeg;base64,'.$result['logo'].'"/></div>';
                        } else {
                          echo '<div class="text-center"><img height="150" width="150" src="./images/Default/NoImage.png"/></div>';
                        }
                        echo '<div class="row justify-content-center"><h1>'.$result['nome'].'</h1></div>';
                        echo '<div class="row justify-content-center"><h1>È questa la lega a cui vuoi unirti?</h1></div><br><br>';
                        echo '<div class="row justify-content-center">';
                          echo '<div class="col-sm-4"><div class="row justify-content-center"><a href="./CheckUniscitiLega.php?id_fantalega='.$result['id_fantalega'].'" class="btn btn-lg btn-primary">SI</a></div></div>';
                          echo '<div class="col-sm-4"><div class="row justify-content-center"><a href="./UniscitiLega.php" class="btn btn-lg btn-primary">NO</a></div></div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  } else {
                    if (count($_POST)!=2 ) { header("Location: ./UniscitiLega.php?error=3"); die; }
                    if (empty($_POST["nomeLega"])) {  header("Location: ./UniscitiLega.php?error=4"); die;}
                    if (empty($_POST["parolaOrdine"])) {  header("Location: ./UniscitiLega.php?error=5"); die;}
                    header("Location: ./UniscitiLega.php?error=6");
                  }
                }
              ?>
            </div>
          </div>
        </div>
    </body>
</html>