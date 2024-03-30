<?php
    require_once('./Fantacalcio.php');
    session_start();
    if(empty($_SESSION["id_fantallenatore"])){
        header("Location: ./login.php");die;
    }
    if(empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])){
        header("Location: ./SelezionaLega.php");die;
    }
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/ViewSquadre.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  </head>
  <body>
    <?php
     include("./Navbar.php");
     $fantasquadre = Fantacalcio::getSquadreFantalega($_SESSION["id_fantalega"]);
     echo  '<div class="container">'; 
     echo '<div class="list-group">';
     foreach($fantasquadre as $fantasquadra){
      echo '<a class="list-group-item d-flex list-group-item-action justify-content-between align-items-center squadra" href="./ViewDettaglioSquadra.php?id_fantasquadra='.$fantasquadra["id_fantasquadra"].'">';
        if($fantasquadra["stemma"]==NULL){
            echo '<img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/>';
          } else {
            echo '
            <img class="immagine" src="data:image/jpeg;base64,'.$fantasquadra["stemma"].'" alt="stemma_'.$fantasquadra["nome"].'"/>';
          }
          echo '<h1>'.ucwords($fantasquadra["nome"]).'</h1>';
          echo '<h2>'.$fantasquadra["crediti"].' crediti</h2></a>';
          
     }
     
     echo  '</div">';
     echo  '</div">'; 

    ?>
    <br><br>
  </body>

</html>
