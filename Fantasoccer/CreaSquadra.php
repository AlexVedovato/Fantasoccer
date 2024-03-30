<?php
require_once('Fantacalcio.php');
session_start();
if (empty($_SESSION["id_fantallenatore"])) {
    header("Location: ./login.php");
    die;
}
?>

<html>

<head>

    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/CreaLega.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./js/CreaLegaOrSquadra.js"></script>
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
                            echo 'Manca il nome della squadra.';
                        } else if ($_GET['error'] == 2) {
                            echo 'Esiste già una fantasquadra con questo nome, per cui ti chiediamo di cambiarlo.';
                        } else if ($_GET['error'] == 3) {
                            echo 'Purtroppo non è stato possibile creare la tua squadra con tutte le informazioni che la riguardano.';
                        } else if ($_GET['error'] == 4) {
                            echo 'Formato del file non accettabile.';
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

    <div class="box container">

        <h1 class="text-center">Crea la tua squadra</h1>

        <form method="POST" action="./checkCreaSquadra.php" enctype="multipart/form-data">
            <h2>Informazioni generali</h2>
            <div class="form-group">
                <label for="inputFirstName">Dai un nome alla tua squadra</label>
                <input type="text" class="form-control" id="inputNome" name="nome">
            </div>

            <div class="form-group">
                <label for="inputStemma">Inserisci uno stemma per la tua squadra</label>
                <div id="drop_file_zone" ondrop="set_file(event)" ondragover="return false">
                    <div id="drag_upload_file">
                        <br>
                        <p>Lascia il file qui</p>
                        <p>oppure</p>
                        <p><input type="file" name="image" id="selectfile"></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="row justify-content-start"><a style="margin-left: 15px"><button type="submit" class="btn btn-primary">Crea la tua squadra</button></a></div>
                </div>
                <div class="col-6">
                    <div class="row justify-content-end"><a style="margin-right: 15px" href="./SelezionaLega.php" class="btn btn-info">Torna indietro</a></div>
                </div>
            </div>
        </form>

    </div>


</body>

</html>