<?php
session_start();

if(empty($_SESSION["id_admin"])){
  header("Location: ./login.php?type=Admin");die;
}
?>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/AreaAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>

  </head>
<body>
<div class="container">
<div class="column">
<div class="row">
  <button class="btn-3" onclick="location.href='./GestioneCalciatori/index.php'">GESTIONE CALCIATORI</button>
  <button class="btn-3" onclick="location.href='./GestioneSquadre/index.php'">GESTIONE SQUADRE SERIE A</button>
  <button class="btn-3" onclick="location.href='./GestionePartite/index.php'">GESTIONE PARTITE SERIE A</button>
  <button class="btn-3" onclick="location.href='./GestioneBonus/index.php'">GESTIONE BONUS</button>
  <button class="btn-3" onclick="location.href='./GestioneModuli/index.php'">GESTIONE MODULI</button>
  <button class="btn-3" onclick="location.href='./GestionePagellisti/index.php'">GESTIONE PAGELLISTI</button>
</div>
</div>
</div>
</body>
</html>