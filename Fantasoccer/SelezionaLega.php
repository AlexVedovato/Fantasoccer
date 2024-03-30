<?php
require_once('Fantacalcio.php');
session_start();

if(empty($_SESSION["id_fantallenatore"])){
  header("Location: ./login.php");die;
}
?>
<html lang="it">

<head>
  <link rel="stylesheet" type="text/css" href="./css/SelezionaLega.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="DataTables-1.10.23/datatables.min.css" />
  <title>Partecipa ad una lega</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
</head>

<body class="immagineSfondo contenitore align-middle">
  <br>
  <div class="row fadeInDown contenitore h-100">

    <div class="col-sm-1"></div>

    <div class="col-sm-3">
      <div class="card" style="width: 300px;">
        <img class="card-img-top" src="./images/Ronaldo.jpg" alt="Ronaldo" height="350" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">Crea una lega</h5>
          <p class="card-text">Crea una lega tutta tua e invita i tuoi amici per uno dei giochi piu' belli del mondo!</p>
          <a href="./CreaLega.php" class="btn btn-primary">CREA</a>
        </div>
      </div>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-3">
      <div class="card" style="width: 300px;">
        <img class="card-img-top" src="./images/Ibrahimovic.jpg" alt="Ibrahimovic" height="350" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">Unisciti ad una lega</h5>
          <p class="card-text">Unisciti ad una lega e cerca di sconfiggere tutti i tuoi avversari costruendo la squadra migliore!</p>
          <a href="./UniscitiLega.php" class="btn btn-primary">UNISCITI</a>
        </div>
      </div>
    </div>
    <div class="col-sm-1"></div>

    <div class="col-sm-3 tabella">
      <table id="list" class="cell-border tabella">
        <thead>
          <tr>
            <th>Le tue leghe</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $list = Fantacalcio::getListaLeghe($_SESSION["id_fantallenatore"]);
          if (!(is_null($list))) {
            foreach ($list as $lega) {

          ?>

              <tr>
                <td>
                  <a href="./EntraLega.php?id_fantalega=<?php echo($lega["id_fantalega"]) ?>" style="text-decoration:none; color:black;"><?php echo ($lega["nome"]); ?></a>
                </td>
              </tr>
          <?php
            }
          }
          ?>



        </tbody>
      </table>
    </div>


  </div>



</body>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
<script src="popper-1.15.0/js/popper.min.js"></script>
<script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables-1.10.23/datatables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#list').DataTable({
      "paging": false,
      "info": false, 
      "language": {
            "zeroRecords": "Nessuna lega trovata",
            "infoEmpty": "Nessuna lega trovata",
            "search": "Trova:   "
        }
    });
  });
</script>

</html>