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
    <link rel="stylesheet" type="text/css" href="./css/ViewPartecipanti.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  </head>
  <body>
    <?php
     include("./Navbar.php");
     $fantallenatori = Fantacalcio::getFantallenatoriFantelega($_SESSION["id_fantalega"]);
     echo  '<div class="container">'; 
     echo '<div class="list-group">';
     foreach($fantallenatori as $fantallenatore ){
      echo '<a class="list-group-item d-flex list-group-item-action justify-content-between align-items-center squadra".>';
          echo '<h4>'.ucwords($fantallenatore["username"]).'</h4>';
          echo '<h4>'.$fantallenatore["email"].' </h4>';
          if($fantallenatore["amministratoreSN"]== "S"){
            echo '<img class="immagine" src="./images/Default/Corona.png" alt="corona"/>';
             }else{
            echo "&nbsp";
             }
          echo '</a>';
     }
     
     echo  '</div">';
     echo  '</div">'; 

    ?>
    <br><br>
  </body>

</html>