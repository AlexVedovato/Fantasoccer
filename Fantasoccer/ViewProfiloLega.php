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
    <link rel="stylesheet" type="text/css" href="./css/ViewProfiloLega.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  </head>
  <body>
    <?php
     include("./Navbar.php");
     $profiloLega = Fantacalcio::getProfiloFantalega($_SESSION["id_fantalega"]);
    ?>
    <table class="table-rounded">
      <tr>
          <th colspan="3">
            <?php 
              if($profiloLega["logo"]==NULL){
                echo('<img height="100" width="100" src="./images/Default/NoImage.png"/ alt="NoImage">'); 
              } else {
                echo('<img height="150" width="150" src="data:image/jpeg;base64,'.$profiloLega['logo'].'" alt="stemma_'.$profiloLega["nome"].'"/>'); 
              }
              
            ?>
          </th>
      </tr>
      <tr colspan="3"> 
          <td><?php echo('<strong class="nome">'.ucwords($profiloLega["nome"].'</strong>')) ?></td>
      </tr>
      <tr colspan="3"> 
          <td><?php echo("Anno di fondazione: <strong>".$profiloLega["anno_fondazione"]."</strong>") ?></td>
      </tr>
    </table>
    <br><br>
  </body>

</html>