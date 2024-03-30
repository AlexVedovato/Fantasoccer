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
?>

<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./DataTables-1.10.23/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/ViewCalciatori.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="./popper-1.15.0/js/popper.min.js"></script>
    <script src="./bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./DataTables-1.10.23/datatables.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

</head>

<body>
    <?php
    include("./Navbar.php");
    ?>

    <div class="container">
        <div style="margin-top:90px">
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
                    if (isset($_GET["type"])) {
                        if ($_GET["type"] == "svincolati") {
                            $list = Fantacalcio::getListaCalciatoriSvincolati($_SESSION["id_fantalega"]);
                        } else if ($_GET["type"] == "non_svincolati") {
                            $list = Fantacalcio::getListaCalciatoriNonSvincolati($_SESSION["id_fantalega"]);
                        } else {
                            $list = Fantacalcio::getListaCalciatori();
                        }
                    } else {
                        $list = Fantacalcio::getListaCalciatori();
                    }

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
                                echo '<td><a class="btn btn-primary" href="./viewDettaglioCalciatore.php?id_calciatore=' . $calciatore["id_calciatore"] . '" role="button">Vedi dettaglio</a></td>';
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
                    [25]
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

</body>

</html>