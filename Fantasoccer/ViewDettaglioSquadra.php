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
$fantasquadre = Fantacalcio::getSquadreFantalega($_SESSION["id_fantalega"]);
$idFantasquadre=array();
foreach($fantasquadre as $fantasquadra){
  array_push($idFantasquadre,$fantasquadra["id_fantasquadra"]);
}
if(!in_array($_GET["id_fantasquadra"],$idFantasquadre)){
  header("Location: ./AreaFantallenatore.php?error=15");die;
}

$fantasquadra = Fantacalcio::getDatiFantaquadra($_GET["id_fantasquadra"]);
$calciatoriFantasquadra = Fantacalcio::getCalciatoriFantasquadra($_GET["id_fantasquadra"]);

?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/ViewDettaglioSquadra.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>

</head>

<body>
    <?php
    include("./Navbar.php");
    ?>

    <table class="table-rounded">

        <tr>
            <th colspan="3"><?php
                            $stemmaFantasquadra = Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["stemma"];
                            $nomeFantasquadra = Fantacalcio::getNomeStemmaFantasquadra($fantasquadra["id_fantasquadra"])["nome"];
                            if ($stemmaFantasquadra == NULL) {
                                echo '<div class="row">
        <div class="col">
        <img class="immagine" src="./images/Default/NoImage.png" alt="NoImage"/></div>
        <div class="col align-self-center">' . " " . $nomeFantasquadra . "</div></div>";
                            } else {
                                echo '<div class="row">
        <div class="col">
        <img class="immagine" src="data:image/jpeg;base64,' .
                                    $stemmaFantasquadra . '" alt="stemma_' . $nomeFantasquadra . '"/></div>
        <div class="col align-self-center">' . " " . $nomeFantasquadra . "</div></div>";
                            }
                            ?>
            </th>
        </tr>

        <tr>
            <td align="center" colspan="3"><?php
                                            echo '<div class="row">
    <div class="col">
    <div class="col align-self-center">' . "Fantallenatore: " . "</div></div>" . '
    <div class="col align-self-center">' .  $fantasquadra["username"] . "</div>"; ?></td>
        </tr>
        <tr>
            <td><?php echo ($fantasquadra["vittorie"] * 3 + $fantasquadra["pareggi"]) . '
      <div class="col sottotitoli">' . " Punti" . "</div>"; ?></td>
            <td><?php echo ($fantasquadra["vittorie"] + $fantasquadra["pareggi"] + $fantasquadra["sconfitte"]) . '
      <div class="col sottotitoli">' . " Partite Giocate" . "</div>"; ?></td>
            <td><?php echo ($fantasquadra["punteggio_totale"]) . '
      <div class="col sottotitoli">' . " Punteggio" . "</div>"; ?></td>
        </tr>
        <tr>
            <td><?php echo ($fantasquadra["vittorie"]) . '
      <div class="col sottotitoli">' . " Vittorie" . "</div>"; ?></td>
            <td><?php echo ($fantasquadra["pareggi"]) . '
      <div class="col sottotitoli">' . " Pareggi" . "</div>"; ?></td>
            <td><?php echo ($fantasquadra["sconfitte"]) . '
      <div class="col sottotitoli">' . " Sconfitte" . "</div>"; ?></td>
        </tr>
        <tr>
            <td><?php echo ($fantasquadra["goal_fatti"]) . '
      <div class="col sottotitoli">' . " Goal fatti" . "</div>"; ?></td>
            <td><?php echo ($fantasquadra["goal_subiti"]) . '
      <div class="col sottotitoli">' . " Goal subiti" . "</div>"; ?></td>
            <td><?php echo ($fantasquadra["goal_fatti"] - $fantasquadra["goal_subiti"]) . '
      <div class="col sottotitoli">' . " Differenza reti" . "</div>"; ?></td>
        </tr>
        <tr>
            <td align="center" colspan="3"><?php echo ($fantasquadra["crediti"]) . '
      <div class="col sottotitoli">' . "Crediti rimasti" . "</div>"; ?></td>
        </tr>
    </table>

    <table class="table-rounded">

        <tr>
            <th colspan="4"><?php
                            echo '<div class="row">
        
        <div class="col">' . "Cognome" . "</div>" . '
        <div class="col">' . "Valore" . "</div>" . '
        <div class="col">' . "Costo acquisto" . "</div>" . '
        <div class="col">' . "Dettagli" . "</div></div>"

                            ?>
            </th>
        </tr>

            <?php
            if (count($calciatoriFantasquadra)==0) {
                echo (
                    '<tr>'.
                    '<td><div class="col align-self-center">Nessun calciatore presente</div></td>'.
                    '</tr>'
                        );
            } else {
                foreach ($calciatoriFantasquadra as $calciatoreFantasquadra) {
                    echo (
                '<tr>'.
                '<td><div class="col align-self-center">' .  $calciatoreFantasquadra["cognome"] . "</div></td>".
                '<td><div class="col align-self-center">' . $calciatoreFantasquadra["valore"] ."</div></td>".
                '<td><div class="col align-self-center">' . $calciatoreFantasquadra["costo_acquisto"] ."</div></td>".
                '<td><div class="col align-self-center">' . '<a class="btn btn-primary" href="./ViewDettaglioCalciatore.php?id_calciatore=' . $calciatoreFantasquadra["id_calciatore"] . '" role="button">Vedi dettaglio</a>' . "</div></td>".
                '</tr>'
                    );
            }
        }
                ?>



    </table>




</body>


</html>