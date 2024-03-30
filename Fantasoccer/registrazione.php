<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="./css/Registrazione.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <title>Registrazione</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
  </head>
  <body Align= "center">
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
                    echo 'Mancano i dati di accesso.';
                  } else if($_GET['error']==2){
                    echo 'Manca lo username.';
                  } else if($_GET['error']==3){
                    echo 'Manca la email.';
                  } else if($_GET['error']==4){
                    echo 'Manca la password.';
                  } else if($_GET['error']==5){
                    echo 'Email già utilizzata da un altro utente';
                  } else if($_GET['error']==6){
                    echo 'Username già utilizzato da un altro utente.';
                  } else {
                    echo 'Per un qualche motivo è stato impossibile eseguire la registrazione';
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
    <div>
        <div class="wrapper <?php if(empty($_GET['error'])){echo 'fadeInDown';}?>">
          <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="inactive underlineHover" type="submit"><a href="./login.php"> Accesso </a></h2>
            <h2 class="active" type="submit">Registrazione</h2>
     
        
            <br>
            <br>

            <!-- registrazione Form -->
            <form action="./CheckRegistrazione.php" method="POST">
              <input type="text" id="usernameRegistrazione" <?php if(empty($_GET['error'])){echo 'class="fadeIn second"';}?> name="usernameRegistrazione" placeholder="username">
              <input type="email" id="emailRegistrazione" <?php if(empty($_GET['error'])){echo 'class="fadeIn second"';}?> name="emailRegistrazione" placeholder="email">
              <input type="password" id="password" <?php if(empty($_GET['error'])){echo 'class="fadeIn third"';}?> name="password" placeholder="password">
                  <br>
                  <br>
              <input type="submit" <?php if(empty($_GET['error'])){echo 'class="fadeIn fourth"';}?> value="Registrati">
            </form>
        
          </div>
        </div>
    </div>
  </body>
</html>