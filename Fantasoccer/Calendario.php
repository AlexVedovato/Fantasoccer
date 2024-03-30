<?php
require_once('./Fantacalcio.php');
session_start();
if (empty($_SESSION["id_fantallenatore"])) {
  header("Location: ./login.php");
  die;
}
if (empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])) {
  header("Location: ./SelezionaLega.php");
  die;
}

$partite_fantacalcio = Fantacalcio::getPartiteFantacalcio($_SESSION["id_fantalega"]);
$id_squadre = Fantacalcio::getIDSquadreFantalega($_SESSION["id_fantalega"]);
?>

<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./css/AreaFantallenatore.css">
  <link rel="stylesheet" type="text/css" href="./css/Calendario.css">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
  <script src="popper-1.15.0/js/popper.min.js"></script>
  <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
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
              echo 'Non è stato possibile avviare la competizione.';
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
  <?php
  include("./Navbar.php");
  ?>
  <div class="container">
    <?php
    if ($partite_fantacalcio == NULL) {
      echo '<table class="table-rounded">
      <tr>
          <th colspan="3">
            In attesa che l\'amministratore di lega avvii la competizione.
          </th>
      </tr>
    </table>'; 

    } else {
      $numero_giornata = -1;
      if (!(is_null($partite_fantacalcio))) {
    ?>
        <?php
        foreach ($partite_fantacalcio as $partita_fantacalcio) {
          if ($numero_giornata != $partita_fantacalcio["numero_giornata"]) {
            if($numero_giornata!=-1){
              echo '</tbody></table>' ;
            }
            $numero_giornata = $partita_fantacalcio["numero_giornata"];
        ?>
            <table>
              <tbody>
                <tr>
                  <td class="giornata" colspan="2"><?php echo "<h4>Giornata " . ($partita_fantacalcio["numero_giornata"] . "</h4>") ?></td>
                </tr>
              <?php
            }
                  if(Fantacalcio::isGiornataInCorso($partita_fantacalcio["numero_giornata"])){
                    ?> <tr onclick="location.href=' <?php echo './ViewDettaglioPartitaFantacalcio.php?numero_giornata='.$partita_fantacalcio['numero_giornata'].'&id_fantasquadra_casa='.$partita_fantacalcio['id_fantasquadra_casa'].'&id_fantasquadra_trasferta='.$partita_fantacalcio['id_fantasquadra_trasferta'].'&type=live'; ?>'"> <?php
                  } else {
                    ?> <tr onclick="location.href=' <?php echo './ViewDettaglioPartitaFantacalcio.php?numero_giornata='.$partita_fantacalcio['numero_giornata'].'&id_fantasquadra_casa='.$partita_fantacalcio['id_fantasquadra_casa'].'&id_fantasquadra_trasferta='.$partita_fantacalcio['id_fantasquadra_trasferta']; ?>'"><?php
                  }
              ?>

              
                <td ><?php echo (Fantacalcio::getNomeStemmaFantasquadra($partita_fantacalcio["id_fantasquadra_casa"])["nome"] . " - " .
                      Fantacalcio::getNomeStemmaFantasquadra($partita_fantacalcio["id_fantasquadra_trasferta"])["nome"]) ?></td>
                <td><?php
                    if($partita_fantacalcio["punteggio_casa"]==NULL || $partita_fantacalcio["punteggio_trasferta"]==NULL ){
                      if(Fantacalcio::isGiornataPassata($partita_fantacalcio["numero_giornata"])){
                          echo 'Da calcolare '; 
                      } else if(Fantacalcio::isGiornataInCorso($partita_fantacalcio["numero_giornata"])){
                          echo 'Vai al live'; 
                      }
                    }else{
                    echo (Fantacalcio::getGoals($partita_fantacalcio["punteggio_casa"], $_SESSION["id_fantalega"]) . " - " .
                      Fantacalcio::getGoals($partita_fantacalcio["punteggio_trasferta"], $_SESSION["id_fantalega"]));
                    }

                    ?>
                </td>

              </tr>
          <?php
        }
        echo '</tbody></table>' ;
      }
          ?>
        <?php
      }
        ?>

  </div>
  <br><br> 
</body>


</html>