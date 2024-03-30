<?php
    require_once('./Fantacalcio.php');
    session_start();
    if(empty($_SESSION["id_fantallenatore"])){
        header("Location: ./login.php");die;
    }
    if(empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])){
        header("Location: ./SelezionaLega.php");die;
    }
    if($_SESSION["amministratoreSN"]=='N'){
        header("Location: ./AreaFantallenatore.php");die;
    }
?>

<!doctype html>
<html lang="it">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/CalcolaGiornate.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
                    echo 'Manca il numero della giornata da calcolare.';
                  } else if ($_GET['error']==2){
                    echo 'Non è ancora possibile calcolare questa giornata.';
                  } else if ($_GET['error']==3){
                    echo 'La giornata che volevi calcolare non è presente nella tua lega.';
                  } else if ($_GET['error']==4){
                    echo 'La giornata che volevi calcolare è già stata calcolata.';
                  } else if ($_GET['error']==5){
                    echo 'Impossibile calcolare la giornata.';
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
     $ultimaGiornata = Fantacalcio::getNumeroLastGiornata();
     $primaGiornata = Fantacalcio::getNumeroPrimaGiornata($_SESSION["id_fantalega"]);
     if(Fantacalcio::isGiornataInCorso($ultimaGiornata)){
        $ultimaGiornata-=1;
     }
     echo  '<div class="container">'; 
     echo '<div class="list-group">';
     $j=1;
     for($i=$primaGiornata;$i<=$ultimaGiornata;$i++,$j++){  
        if (Fantacalcio::isGiornataCalcolata($i, $_SESSION["id_fantalega"])){
            echo '<a class="list-group-item d-flex justify-content-between align-items-center squadra">';
            echo '<div class="col"><h2>'.$j.' giornata di lega</h2>';
            echo '<h3>'.$i.' giornata di serie A</h3></div>';
            echo '<h2><i class="fas fa-check-square"></i></h2>';
        } else {
            echo '<a class="list-group-item d-flex list-group-item-action justify-content-between align-items-center squadra" href="./CalcolaGiornata.php?numero_giornata='.$i.'">';
            echo '<div class="col"><h2>'.$j.' giornata di lega</h2>';
            echo '<h3>'.$i.' giornata di serie A</h3></div>';
            echo '<h2><i class="fas fa-calculator"></i></h2>';
        }
     } 
     
     echo  '</div">';
     echo  '</div">'; 

    ?>
  </body>

</html>