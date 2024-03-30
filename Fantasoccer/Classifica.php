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
    <link rel="stylesheet" type="text/css" href="./css/Classifica.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
    <script src="popper-1.15.0/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  </head>

  <body>

    <?php 
        include("./Navbar.php");
        $posizione=0; 
    ?>

    <div class="container">
        <table id="list">
            <thead>
                <tr>
                    <th>Posizione</th>
                    <th>Nome</th>
                    <th>Partite giocate</th>
                    <th>Vittorie</th>
                    <th>Pareggi</th>
                    <th>Sconfitte</th>
                    <th>Goal fatti</th>
                    <th>Goal subiti</th>
                    <th>Punti</th>
                    <th>Punteggio totale</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $list = Fantacalcio::getClassifica($_SESSION["id_fantalega"]);
                    if (!(is_null($list)))  {
                        foreach ($list as $classifica) {
                    ?> 
                    <tr>
                    <td><?php echo($posizione=$posizione + 1)?></td>
                    <td><?php echo(ucwords($classifica["nome"]))?></td>
                    <td><?php echo(($classifica["vittorie"])+($classifica["pareggi"])+($classifica["sconfitte"]))?></td>
                    <td><?php echo(($classifica["vittorie"]))?></td>
                    <td><?php echo(($classifica["pareggi"]))?></td>
                    <td><?php echo(($classifica["sconfitte"]))?></td>
                    <td><?php echo(($classifica["goal_fatti"]))?></td>
                    <td><?php echo(($classifica["goal_subiti"]))?></td>
                    <td><?php echo(($classifica["punti"]))?></td>
                    <td><?php echo(($classifica["punteggio_totale"]))?></td>

                    </tr>
                    <?php
                                                    }
                                                }
                ?>
            </tbody>
        </table>
    </div>
<br><br><br>
</script>
  </body>
</html>


