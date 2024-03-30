<?php
require_once('../Fantacalcio.php');
session_start();

if(empty($_SESSION["id_admin"])){
   header("Location: ../login.php?type=Admin");die;
}
?>

<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../DataTables-1.10.23/datatables.min.css"/>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="../popper-1.15.0/js/popper.min.js"></script>
    <script src="../bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script src="../js/Gestioni.js"></script>
    <script type="text/javascript" src="../DataTables-1.10.23/datatables.min.js"></script>
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
                    echo 'Impossibile inserire la squadra';
                  } else if ($_GET['error']==2){ 
                    echo 'Non troviamo la squadra di cui vuoi modificare i dati.';
                  } else if ($_GET['error']==3){
                    echo 'Impossibile modificare i dati della squadra.';
                  } else if ($_GET['error']==4){
                    echo 'Impossibile eliminare la squadra.';
                  } else if ($_GET['error']==5){
                    echo 'Mancava l\'id della squadra, per questo non è stato possibile modificare i suoi dati e sei stato reinderizzato qui.';
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

    <div class="container">
        <div class="fixed-top">
            <nav class="navbar navbar-light bg-info">
                <a class="navbar-brand" href="#">GESTIONE SQUADRE SERIE A</a>
            </nav>
        </div>
        <div style="margin-top:90px">
        <a class="btn btn-success mt-3 mb-3" href="./viewSquadra.new.php">Nuova <i class="fas fa-plus-square"></i></a>
        <a class="btn btn-warning mt-3 mb-3 float-right" href="../logout.php?type=id_admin">Logout</a>
        

        <table id="list" class="display compact" style="width:100%">
        <thead>
            <tr>
                <th>ID Squadra Serie A</th>
                <th>Nome</th>
                <th>Stemma</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
<?php 
    $list = Fantacalcio::getListaSquadre();
    if (!(is_null($list)))  {
        foreach ($list as $squadra) {
?> 

<tr>
<td><?php echo($squadra["id_squadra_serieA"])?></td>
<td><?php echo(ucwords($squadra["nome"]))?></td>
<td>
<?php
    if($squadra["stemma"]==NULL){
      echo '<img width="50px" height="50px" src="../images/Default/NoImage.png" alt="NoImage"/>';
    } else {
      echo '<img width="50px" height="50px" src="data:image/jpeg;base64,'.$squadra["stemma"].'" alt="'.$squadra["nome"].'"/>';
    }
?>
</td>
<?php
    echo '<td><a class="btn btn-primary" href="./viewSquadra.update.php?id_squadra_serieA='.$squadra["id_squadra_serieA"].'" role="button"><i class="fas fa-pencil-alt"></i></a></td>';
    echo '<td><a class="btn btn-danger" onclick="passDataSquadra('.$squadra["id_squadra_serieA"].')" href="" data-toggle="modal" data-target="#modalDelete" role="button"><i class="fas fa-minus-circle"></i></a></td>';
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
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
                "order": [[ 0, "desc" ]]
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
        <div class="modal-body">
            La cancellazione di una squadra dal database potrebbe comportare problemi enormi, andando a cancellare pure il riferimento per le partite di serie A in cui la squadra era coinvolta e quello per i calciatori della squadra, pertanto è consigliato farlo solo se la squadra non è presente in nessuna partita e non ha nessun calciatore oppure se la stagione è ormai terminata e ne deve iniziare una nuova, con conseguente rinnovamento del database. Sei sicuro di voler continuare?
        </div>
        <div class="modal-footer" id="modal-footer">
        </div>
    </div>
    </div>
</div>
</body>

</html>