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

$fantasquadra = Fantacalcio::getFantaquadra($_SESSION["id_fantallenatore"], $_SESSION["id_fantalega"]);
if ($fantasquadra == NULL) {
  header("Location: ./CreaSquadra.php");
  die;
}
?>

<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./css/AreaFantallenatore.css">
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
                    echo 'Mancano le informazioni necessarie per visualizzare la partita.';
                  } else if ($_GET['error']==2){
                    echo 'Manca il numero della giornata della partita che si voleva visualizzare.';
                  } else if ($_GET['error']==3){
                    echo 'Manca l\'id della squadra in casa nella partita che si voleva visualizzare.';
                  } else if ($_GET['error']==4){
                    echo 'Manca l\'id della squadra in trasferta nella partita che si voleva visualizzare.';
                  } else if ($_GET['error']==5){
                    echo 'Le squadre della partita che si voleva visualizzare non fanno parte della lega.';
                  } else if ($_GET['error']==6){
                    echo 'La partita che si voleva visualizzare non esiste.';
                  } else if ($_GET['error']==7){
                    echo 'Manca l\'id del modulo della formazione.';
                  } else if ($_GET['error']==8){
                    echo 'Manca il numero della giornata per cui inserire la formazione';
                  } else if ($_GET['error']==9){
                    echo 'Il tempo per inserire la formazione è scaduto.';
                  } else if ($_GET['error']==10){
                    echo 'Numero di giocatori insufficiente per poter inserire la formazione.';
                  } else if ($_GET['error']==11){
                    echo 'Modulo non consentito nella tua lega.';
                  } else if ($_GET['error']==12){
                    echo 'Non puoi inserire nella tua formazione giocatori che non appartengono alla tua fantasquadra.';
                  } else if ($_GET['error']==13){
                    echo 'Non è stato possibile inserire la formazione.';
                  } else if ($_GET['error']==14){
                    echo 'E\' già stata inserita una formazione per questa giornata.';
                  } else if ($_GET['error']==15){
                    echo 'La squadra precedentemente selezionata non fa parte della fantalega.';
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

  <table class="table-rounded">

    <tr>
      <th colspan="3"><?php

                      if (Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["stemma"] == NULL) {
                        echo '<div class="row">
        <div class="col">
        <img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>
        <div class="col align-self-center">' . " " . Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["nome"] . "</div></div>";
                      } else {
                        echo '<div class="row">
        <div class="col">
        <img class="immagine" src="data:image/jpeg;base64,' .
                          Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["stemma"] . '" alt="stemma_' . Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["nome"] . '"/></div>
        <div class="col align-self-center">' . " " . Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["nome"] . "</div></div>";
                      }
                      ?>
      </th>
    </tr>
    <tr>
      <td><?php echo ($fantasquadra["vittorie"] * 3 + $fantasquadra["pareggi"]) . '
      <div class="col sottotitoli">' . " Punti" . "</div>"; ?></td>
      <td><?php echo ($fantasquadra["vittorie"] + $fantasquadra["pareggi"] + $fantasquadra["sconfitte"]) . '
      <div class="col sottotitoli">' . " Partite Giocate" . "</div>"; ?></td>
      <td><?php echo ($fantasquadra["punteggio_totale"]) . '
      <div class="col sottotitoli">' . " Punteggio" . "</div>"; ?></td>
    </tr>
  </table>

  <?php
  if (Fantacalcio::isCompetizioneAvviata($_SESSION["id_fantalega"])) {
    $lastGiornata = Fantacalcio::getNumeroLastGiornata();
    $scorsa_partita = Fantacalcio::getPartitaFantacalcioFantasquadra($lastGiornata, $fantasquadra["id_fantasquadra"], $_SESSION["id_fantalega"]);
    $nextGiornata = Fantacalcio::getNumeroNextGiornata();
    $prossima_partita = Fantacalcio::getPartitaFantacalcioFantasquadra($nextGiornata, $fantasquadra["id_fantasquadra"], $_SESSION["id_fantalega"]);
    if ($nextGiornata != Fantacalcio::getNumeroPrimaGiornata($_SESSION["id_fantalega"])) {
  ?>

      <table class="table-rounded">
        <?php
        if (Fantacalcio::isGiornataInCorso($lastGiornata)) {
          echo '<tr><th colspan="5"><h1>Giornata corrente</h1></th></tr>';
        } else {
          echo '<tr><th colspan="5"><h1>ultima giornata</h1></th></tr>';
        }
        ?>
        <tr>
          <td colspan="5">
            <?php
            if ($scorsa_partita["stemma_casa"] == NULL) {
              echo '<div class="row">
            <div class="col"><img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>
            <div class="col align-self-center">' . " " . $scorsa_partita["nome_casa"] . ' </div>
            <div class="col align-self-center">';
              if (!is_null($scorsa_partita["punteggio_casa"]) && !is_null($scorsa_partita["punteggio_trasferta"])) {
                echo Fantacalcio::getGoals($scorsa_partita["punteggio_casa"], $_SESSION["id_fantalega"]) . '-' . Fantacalcio::getGoals($scorsa_partita["punteggio_trasferta"], $_SESSION["id_fantalega"]);
              } else {
                echo '-';
              }
              echo '</div>';
              if ($scorsa_partita["stemma_trasferta"] == NULL) {
                echo '<div class="col align-self-center">' . " " . $scorsa_partita["nome_trasferta"] . ' </div>
            <div class="col"><img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>';
              } else {
                echo '<div class="col align-self-center">' . " " . $scorsa_partita["nome_trasferta"] . '</div>
            <div class="col"><img class="immagine" src="data:image/jpeg;base64,' . $scorsa_partita["stemma_trasferta"] . '" alt="stemma_' . $scorsa_partita["nome_trasferta"] . '"/></div>';
              }
              echo '</div>';
            } else {
              echo '<div class="row">
            <div class="col"><img class="immagine" src="data:image/jpeg;base64,' . $scorsa_partita["stemma_casa"] . '" alt="stemma_' . $scorsa_partita["nome_casa"] . '"/></div>
            <div class="col align-self-center">' . " " . $scorsa_partita["nome_casa"] . ' </div>
            <div class="col align-self-center">';
              if (!is_null($scorsa_partita["punteggio_casa"]) && !is_null($scorsa_partita["punteggio_trasferta"])) {
                echo Fantacalcio::getGoals($scorsa_partita["punteggio_casa"], $_SESSION["id_fantalega"]) . '-' . Fantacalcio::getGoals($scorsa_partita["punteggio_trasferta"], $_SESSION["id_fantalega"]);
              } else {
                echo '-';
              }
              echo '</div>';
              if ($scorsa_partita["stemma_trasferta"] == NULL) {
                echo '<div class="col align-self-center">' . " " . $scorsa_partita["nome_trasferta"] . ' </div>
            <div class="col"><img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>';
              } else {
                echo '<div class="col align-self-center">' . " " . $scorsa_partita["nome_trasferta"] . '</div>
            <div class="col"><img class="immagine" src="data:image/jpeg;base64,' . $scorsa_partita["stemma_trasferta"] . '" alt="stemma_' . $scorsa_partita["nome_trasferta"] . '"/></div>';
              }
            }
            ?>
          </td>
        </tr>
        <?php
        if (Fantacalcio::isGiornataInCorso($lastGiornata)) {
          echo '<tr><td colspan="5"><a type="button" href="./ViewDettaglioPartitaFantacalcio.php?numero_giornata=' . $lastGiornata . '&id_fantasquadra_casa=' . $scorsa_partita["id_fantasquadra_casa"] . '&id_fantasquadra_trasferta=' . $scorsa_partita["id_fantasquadra_trasferta"] . '&type=live" class="btn btn-primary">Vai al live</a></td></tr>';
        } else {
          echo '<tr><td colspan="5"><a type="button" href="./ViewDettaglioPartitaFantacalcio.php?numero_giornata=' . $lastGiornata . '&id_fantasquadra_casa=' . $scorsa_partita["id_fantasquadra_casa"] . '&id_fantasquadra_trasferta=' . $scorsa_partita["id_fantasquadra_trasferta"] . '" class="btn btn-primary">Vedi i dettagli della partita</a></td></tr>';
        }
        ?>
      </table>

    <?php
    }
    if (($lastGiornata != Fantacalcio::getNumeroGiornate() || !Fantacalcio::isGiornataInCorso($lastGiornata)) && !Fantacalcio::isGiornataPassata(Fantacalcio::getNumeroGiornate())) {
    ?>

      <table class="table-rounded">

        <tr>
          <th colspan="5">
            <h1>Prossima giornata</h1>
          </th>
        </tr>
        <tr>
          <td colspan="5">
            <?php
            if ($prossima_partita["stemma_casa"] == NULL) {
              echo '<div class="row">
            <div class="col"><img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>
            <div class="col align-self-center">' . " " . $prossima_partita["nome_casa"] . ' </div>
            <div class="col align-self-center">';
              if (!is_null($prossima_partita["punteggio_casa"]) && !is_null($prossima_partita["punteggio_trasferta"])) {
                echo Fantacalcio::getGoals($prossima_partita["punteggio_casa"], $_SESSION["id_fantalega"]) . '-' . Fantacalcio::getGoals($prossima_partita["punteggio_trasferta"], $_SESSION["id_fantalega"]);
              } else {
                echo '-';
              }
              echo '</div>';
              if ($prossima_partita["stemma_trasferta"] == NULL) {
                echo '<div class="col align-self-center">' . " " . $prossima_partita["nome_trasferta"] . ' </div>
            <div class="col"><img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>';
              } else {
                echo '<div class="col align-self-center">' . " " . $prossima_partita["nome_trasferta"] . '</div>
            <div class="col"><img class="immagine" src="data:image/jpeg;base64,' . $prossima_partita["stemma_trasferta"] . '" alt="stemma_' . $prossima_partita["nome_trasferta"] . '"/></div>';
              }
              echo '</div>';
            } else {
              echo '<div class="row">
            <div class="col"><img class="immagine" src="data:image/jpeg;base64,' . $prossima_partita["stemma_casa"] . '" alt="stemma_' . $prossima_partita["nome_casa"] . '"/></div>
            <div class="col align-self-center">' . " " . $prossima_partita["nome_casa"] . ' </div>
            <div class="col align-self-center">';
              if (!is_null($prossima_partita["punteggio_casa"]) && !is_null($prossima_partita["punteggio_trasferta"])) {
                echo Fantacalcio::getGoals($prossima_partita["punteggio_casa"], $_SESSION["id_fantalega"]) . '-' . Fantacalcio::getGoals($prossima_partita["punteggio_trasferta"], $_SESSION["id_fantalega"]);
              } else {
                echo '-';
              }
              echo '</div>';
              if ($prossima_partita["stemma_trasferta"] == NULL) {
                echo '<div class="col align-self-center">' . " " . $prossima_partita["nome_trasferta"] . ' </div>
            <div class="col"><img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>';
              } else {
                echo '<div class="col align-self-center">' . " " . $prossima_partita["nome_trasferta"] . '</div>
            <div class="col"><img class="immagine" src="data:image/jpeg;base64,' . $prossima_partita["stemma_trasferta"] . '" alt="stemma_' . $prossima_partita["nome_trasferta"] . '"/></div>';
              }
            }
            ?>
          </td>
        </tr>


        <?php
        if (!Fantacalcio::isGiornataInCorso($lastGiornata)) {
          $dataInizio = Fantacalcio::getInizioGiornata($nextGiornata, $_SESSION["id_fantalega"]);
        ?>

          <tr>
            <td colspan="5">
              <p id="timer"></p>

              <script>
                // Set the date we're counting down to "May 22, 2021 18:00:00"
                var countDownDate = new Date("<?php echo($dataInizio) ?>").getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                  // Get today's date and time
                  var now = new Date().getTime();

                  // Find the distance between now and the count down date
                  var distance = countDownDate - now;

                  // Time calculations for days, hours, minutes and seconds
                  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                  // Output the result in an element with id="demo"
                  document.getElementById("timer").innerHTML = "Tempo rimasto:  " + days + "g " + hours + "o " +
                    minutes + "m " + seconds + "s ";

                }, 1000);
              </script>
            </td>
          </tr>

      <?php
          if(Fantacalcio::getModulo(Fantacalcio::getModuloFormazione($fantasquadra["id_fantasquadra"], $nextGiornata))!=null){
            echo '<tr><td colspan="5"><a type="button" href="./ViewDettaglioPartitaFantacalcio.php?numero_giornata=' . $nextGiornata . '&id_fantasquadra_casa=' . $prossima_partita["id_fantasquadra_casa"] . '&id_fantasquadra_trasferta=' . $prossima_partita["id_fantasquadra_trasferta"] . '" class="btn btn-primary">Vedi i dettagli della prossima partita</a></td></tr>'; 
          } else {
            echo '<tr><td colspan="5"><a type="button" href="./InserisciFormazione.php" class="btn btn-primary">Inserisci la formazione</a></td></tr>'; 
          }
        }
      } else if(Fantacalcio::isGiornataPassata(Fantacalcio::getNumeroGiornate())){
        if(Fantacalcio::getNumeroGiornateCalcolate($_SESSION["id_fantalega"])==Fantacalcio::getNumeroGiornate()-Fantacalcio::getNumeroPrimaGiornata($_SESSION["id_fantalega"])+1){
          $classifica=Fantacalcio::getClassifica($_SESSION["id_fantalega"]);
          ?>
            <table class="table-rounded">
              <tr>
                <th colspan="3">
                  Podio finale della fantalega:
                </th>
              </tr>
              <tr>
                <td>
                <div class="podium">
                  <table id="podium">
                    <tr>
                      <td class="altare" style="border: 0px solid; vertical-align: bottom; padding: 3px;">
                        <div class="text-center">2</div>
                        <div id="second">
                          <div class="text-inside">
                            <span class="player">
                            <?php 
                              if(count($classifica)>1){
                                echo $classifica[1]["nome"];
                              } else {
                                echo '-';
                              }
                            ?>
                            </span>
                            <span class="points">
                            <?php 
                              if(count($classifica)>1){
                                echo $classifica[1]["punti"].' punti';
                              }
                            ?> 
                            </span>
                          </div>
                        </div>
                      </td>
                      <td class="altare" style="border: 0px solid; vertical-align: bottom; padding: 3px;">
                        <div class="text-center">1</div>
                        <div id="first">
                        <div class="text-inside">
                            <span class="player">
                            <?php echo $classifica[0]["nome"] ?>
                            </span>
                            <span class="points">
                            <?php echo $classifica[0]["punti"] ?> punti
                            </span>
                          </div>
                        </div>
                      </td>
                      <td class="altare" style="border: 0px solid; vertical-align: bottom; padding: 3px;">
                        <div class="text-center">3</div>
                        <div id="third">
                          <div class="text-inside">
                            <span class="player">
                            <?php 
                              if(count($classifica)>2){
                                echo $classifica[2]["nome"];
                              } else {
                                echo '-';
                              }
                            ?>
                            </span>
                            <span class="points">
                            <?php 
                              if(count($classifica)>2){
                                echo $classifica[2]["punti"].' punti';
                              }
                            ?>
                            </span>
                          </div>
                        </div>
                      </td>
                    </tr>
                </table>
                </div>
                </td>
              </tr>
            </table>
          <?php
        } else {
          ?>
            <table class="table-rounded">
              <tr>
                <th colspan="3">
                  In attesa che l'amministratore di lega calcoli le giornate mancanti per decretare ufficialmente il vincitore della fantalega.
                </th>
              </tr>
            </table>
          <?php
        }
      }
      ?>
      </table>
    <?php
  } else {
    ?>
      <table class="table-rounded">
        <tr>
          <th colspan="3">
            In attesa che l'amministratore di lega avvii la competizione.
          </th>
        </tr>
      </table>
    <?php
  }
    ?>
</body>


</html>