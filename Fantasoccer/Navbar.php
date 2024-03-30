<?php
    require_once('Fantacalcio.php');
    $url=explode("/",$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    $pagina=explode(".",end($url))[0];
    $isCompetizioneAvviata=Fantacalcio::isCompetizioneAvviata($_SESSION["id_fantalega"]);
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <img class="navbar-brand" width="397" height="119" src="./images/Default/logo.png" alt="Logo_sito">

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($pagina=="AreaFantallenatore"){echo('active');}?>">
                    <a class="nav-link" href="./AreaFantallenatore.php">Home</a>
                </li>
                <li class="nav-item <?php if($pagina=="Calendario"){echo('active');}?>">
                    <a class="nav-link" href="./Calendario.php">Calendario</a>
                </li>
                <li class="nav-item <?php if($pagina=="Classifica"){echo('active');}?>">
                    <a class="nav-link" href="./Classifica.php">Classifica</a>
                </li>
                <li class="nav-item <?php if($pagina=="ViewSquadre" || $pagina=="Regolamento" || $pagina=="ViewPartecipanti" || $pagina=="ViewProfiloLega" || $pagina=="ViewDettaglioSquadra"){echo('active');}?> dropdown" >
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Informazioni sulla lega
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./ViewProfiloLega.php">Profilo Lega</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./ViewPartecipanti.php">Partecipanti</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./ViewSquadre.php">Squadre</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./Regolamento.php">Regolamento</a>
                    </div>
                </li>
                <li class="nav-item <?php if($pagina=="ViewCalciatori"){echo('active');}?> dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Informazioni sui calciatori
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./ViewCalciatori.php">Lista completa dei calciatori</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./ViewCalciatori.php?type=svincolati">Lista calciatori svincolati</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./ViewCalciatori.php?type=non_svincolati">Lista calciatori non svincolati</a>
                    </div>
                </li>
                <?php
                    if($_SESSION["amministratoreSN"]=='S'){
                        ?>
                        <li class="nav-item <?php if($pagina=="AcquistaCalciatori" || $pagina=="SvincolaCalciatori" || $pagina=="CalcolaGiornate"){echo('active');}?> dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gestione della lega
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./AcquistaCalciatori.php">Acquista calciatori</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./SvincolaCalciatori.php">Svincola calciatori</a>
                                <?php
                                    if(!$isCompetizioneAvviata){
                                        echo '<div class="dropdown-divider"></div>';
                                        echo '<a class="dropdown-item" data-toggle="modal" href="" data-target="#modalConfirm" role="button">Avvia competizione</a>';
                                    } else {
                                        echo '<div class="dropdown-divider"></div>';
                                        echo '<a class="dropdown-item" href="./CalcolaGiornate.php">Calcola giornate</a>';
                                    }
                                ?>
                            </div>
                        </li>
                        <?php
                    }
                ?>
            </ul>
            <span class="align-middle">
                <div class="col">
                    <a class="btn btn-warning" style="width:120px;margin:3px;" href="./SelezionaLega.php">Cambia lega</a>
                    <a class="btn btn-warning" style="width:120px;margin:3px;" href="./logout.php?type=id_fantallenatore">Logout</a>
                </div>
            </span>
        </div>
    </nav>
    <?php
      if(!$isCompetizioneAvviata){
        ?><!-- Modal -->
        <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">
                <?php
                    if(Fantacalcio::getNumeroLastGiornata()==Fantacalcio::getNumeroGiornate()){
                        echo 'Ci dispiace!';
                    } else {
                        echo 'Sei veramento sicuro?';
                    }
                ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php
                    if(Fantacalcio::getNumeroLastGiornata()==Fantacalcio::getNumeroGiornate()){
                        echo 'Per poter avviare la competizione sarà necessario attendere un rinnovamento del database che arriverà in prossimità della prossima stagione di serie A!';
                    } else {
                        echo 'Una volta avviata la competizione nessun altro fantallenatore potra unirsi alla fantalega fino al termine della competizione e verrà generato il calendario delle partite della fantalega. Questo processo è irreversibile, sei sicuro di voler continuare?';
                    }
                ?>
                </div>
              <div class="modal-footer">
              <?php
                    if(Fantacalcio::getNumeroLastGiornata()==Fantacalcio::getNumeroGiornate()){
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">OK!</button>';
                    } else {
                        echo '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button>
                              <a type="button" href="./AvviaCompetizione.php" class="btn btn-primary">SI</a>';
                    }
                ?>
                
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    ?>