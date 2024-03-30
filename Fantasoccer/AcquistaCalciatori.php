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
if ($_SESSION["amministratoreSN"] == 'N') {
  header("Location: ./AreaFantallenatore.php");
  die;
}

$fantasquadre = Fantacalcio::getSquadreFantalega($_SESSION["id_fantalega"]);
$idFantasquadre=array();
foreach($fantasquadre as $fantasquadra){
  array_push($idFantasquadre,$fantasquadra["id_fantasquadra"]);
}
if (empty($_GET["id_fantasquadra"])) {
  $_GET["id_fantasquadra"] = $fantasquadre[0]["id_fantasquadra"];
}
if(!in_array($_GET["id_fantasquadra"],$idFantasquadre)){
  header("Location: ./AcquistaCalciatori.php?error=7");die;
}
?>

<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="./bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="./DataTables-1.10.23/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="./css/AcquistaSvincolaCalciatori.css">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
  <script src="./popper-1.15.0/js/popper.min.js"></script>
  <script src="./js/AcquistaSvincolaCalciatori.js"></script>
  <script src="./bootstrap-4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./DataTables-1.10.23/datatables.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
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
              echo 'Mancano i dati necessari per poter il calciatore alla fantasquadra.';
            } else if ($_GET['error'] == 2) {
              echo 'Manca l\' id della fantasquadra.';
            } else if ($_GET['error'] == 3) {
              echo 'Manca l\' id del calciatore.';
            } else if ($_GET['error'] == 4) {
              echo 'Manca il costo d\'acquisto del calciatore.';
            } else if ($_GET['error'] == 5) {
              echo 'Crediti non sufficienti per l\'acquisto.';
            } else if ($_GET['error'] == 6) {
              echo 'La fantasquadra ha già raggiunto il limite massimo di calciatori per questo ruolo.';
            } else if ($_GET['error'] == 7) {
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


  <div class="dropdown  my-menu">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      echo Fantacalcio::getNomeStemmaFantasquadra($_GET["id_fantasquadra"])["nome"];
      ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <?php
      foreach ($fantasquadre as $fantasquadra) {
        echo ' <a class="dropdown-item" href="AcquistaCalciatori.php?id_fantasquadra=' . $fantasquadra["id_fantasquadra"] . '">' . $fantasquadra["nome"] . '</a>';
      }
      ?>
    </div>
  </div>

  <div class="container">
    <div style="margin-top:0px">
      <div class="row">
        <div class="col">
          <?php
          $calciatoriPerRuolo = Fantacalcio::getNumeroGiocatoriRuoloFantasquadra($_GET["id_fantasquadra"]);
          $regolamento = Fantacalcio::getRegolamento($_SESSION["id_fantalega"]);
          echo '<h3>Portieri:</h3>';
          for ($i = 0; $i < $regolamento["numero_portieri"]; $i++) {
            if ($i < $calciatoriPerRuolo["numero_portieri"]) {
              echo '<span class="dot_portiere"></span>';
            } else {
              echo '<span class="dot"></span>';
            }
          }
          echo '</div><div class="col"><h3>Difensori:</h3>';
          for ($i = 0; $i < $regolamento["numero_difensori"]; $i++) {
            if ($i < $calciatoriPerRuolo["numero_difensori"]) {
              echo '<span class="dot_difensore"></span>';
            } else {
              echo '<span class="dot"></span>';
            }
          }
          echo '</div><div class="col align-self-center text-center"><h1>Crediti rimasti: </h1></div></div><div class="row" style="margin-bottom:30px">';
          echo '<div class="col"><h3>Centrocampisti:</h3>';
          for ($i = 0; $i < $regolamento["numero_centrocampisti"]; $i++) {
            if ($i < $calciatoriPerRuolo["numero_centrocampisti"]) {
              echo '<span class="dot_centrocampista"></span>';
            } else {
              echo '<span class="dot"></span>';
            }
          }
          echo '</div><div class="col"><h3>Attaccanti:</h3>';
          for ($i = 0; $i < $regolamento["numero_attaccanti"]; $i++) {
            if ($i < $calciatoriPerRuolo["numero_attaccanti"]) {
              echo '<span class="dot_attaccante"></span>';
            } else {
              echo '<span class="dot"></span>';
            }
          }
          echo '</div><div class="col text-center"><h1>' . Fantacalcio::getCreditiFantasquadra($_GET["id_fantasquadra"]) . '</h1></div>';
          ?>
        </div>
        <table id="list" class="display compact" style="width:100%">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Cognome</th>
              <th>Ruolo</th>
              <th>Squadra</th>
              <th>Valore</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $list = Fantacalcio::getListaCalciatoriSvincolati($_SESSION["id_fantalega"]);
            if (!(is_null($list))) {
              foreach ($list as $calciatore) {
            ?>

                <tr>
                  <td><?php echo ($calciatore["nome"]);
                      if ($calciatore["esteroSN"] == 'S') {
                        echo ("*");
                      } ?></td>
                  <td><?php echo ($calciatore["cognome"]);
                      if ($calciatore["esteroSN"] == 'S') {
                        echo ("*");
                      } ?></td>
                  <td><?php echo ($calciatore["ruolo"]) ?></td>
                  <td><?php echo (ucwords($calciatore["squadra"])) ?></td>
                  <td><?php echo ($calciatore["valore"]) ?></td>
                  <?php

                  echo '<td><a class="btn btn-danger" onclick=' . "'passDataAcquistaCalciatore(" . '"' . $calciatore["nome"] . '","' . $calciatore["cognome"] . '",'
                    . $calciatore["valore"] . ',"' . (Fantacalcio::getNomeStemmaFantasquadra($_GET["id_fantasquadra"])["nome"]) . '",' . $_GET["id_fantasquadra"]
                    . ',' . $calciatore["id_calciatore"] . ")'" . ' data-toggle="modal" data-target="#modalDelete" role="button">Acquista Calciatore</a></td>';
                  ?>

                </tr>
            <?php
              }
            }
            ?>

          </tbody>
        </table>
        <br><br><br><br>
      </div>
    </div>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#list').DataTable({
          "columnDefs": [{
            "className": "dt-center",
            "targets": "_all"
          }],
          "order": [
            [0, "desc"]
          ],


          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bInfo": false,
          "bAutoWidth": true,
          "lengthMenu": [
            [10],
            [10]
          ],


          "info": false,
          "language": {
            "zeroRecords": "Nessun calciatore trovato",
            "infoEmpty": "Nessun calciatore trovato",
            "search": '<font color="black">Trova: </font>',
            sLengthMenu: " _MENU_",
            "paginate": {
              "previous": '<font color="black">Precedente</font>',
              "next": '<font color="black">Successivo</font>',

            },
          },


        });
      });
    </script>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalTitle">Ne sei veramente sicuro sicuro?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="./CheckAcquistaCalciatore.php">
            <div class="modal-body" id="modal-body">

            </div>
            <div class="modal-footer" id="modal-footer">
            </div>
          </form>
        </div>
      </div>
    </div>
</body>

</html>