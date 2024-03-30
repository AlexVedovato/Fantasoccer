<?php
	require_once('./Fantacalcio.php');
    session_start();
    if(empty($_SESSION["id_fantallenatore"])){
        header("Location: ./login.php");die;
    }
    if(empty($_SESSION["id_fantalega"]) || empty($_SESSION["amministratoreSN"])){
        header("Location: ./SelezionaLega.php");die;
    }

	$fantasquadra = Fantacalcio::getFantaquadra($_SESSION["id_fantallenatore"], $_SESSION["id_fantalega"]);
	if ($fantasquadra == NULL) {
		header("Location: ./CreaSquadra.php");
	die;
	}
	$calciatori=Fantacalcio::getCalciatoriFantasquadra($fantasquadra["id_fantasquadra"]);
?>
<html>
	<head>
		<link rel="stylesheet" href="./css/InserisciFormazione.css">
		<script src="./js/InserisciFormazione.js"></script>
		<link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css">
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="jquery-3.4.1/js/jquery-3.4.1.min.js"></script>
		<script src="popper-1.15.0/js/popper.min.js"></script>
		<script src="bootstrap-4.3.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<section id="html5-drag">
			<div class="wrapper">
				<div class="menu-wrapper">
						<ul class="menu" id="holder">
							<?php
								foreach($calciatori as $calciatore){
									echo '<li>';
									if($calciatore["ruolo"]=="Portiere"){
										echo '<div class="drag_portiere"';
									} else if($calciatore["ruolo"]=="Difensore"){
										echo '<div class="drag_difensore"';
									} else if($calciatore["ruolo"]=="Centrocampista"){
										echo '<div class="drag_centrocampista"';
									} else {
										echo '<div class="drag_attaccante"';
									}
									echo ' id="box'.$calciatore["id_calciatore"].'" draggable="true" ondragstart="return dragStart(event)">';
									echo '<input type="text" value="'.$calciatore["id_calciatore"].'" ';
									if($calciatore["ruolo"]=="Portiere"){
										echo 'name="portieri[]"';
									} else if($calciatore["ruolo"]=="Difensore"){
										echo 'name="difensori[]"';
									} else if($calciatore["ruolo"]=="Centrocampista"){
										echo 'name="centrocampisti[]"';
									} else {
										echo 'name="attaccanti[]"';
									}
									echo ' hidden>';
									echo '<p style="margin-bottom: 3px;">'.substr($calciatore["nome"], 0, 2).'. '.$calciatore["cognome"].'<br></p>';
									if($calciatore["infortunatoSCN"]=='S'){
										echo '<img src="./images/Default/infortunato.png" alt="infortunato" height="30" width="30">';
									} else if($calciatore["infortunatoSCN"]=='C'){
										echo '<img src="./images/Default/covid.png" alt="covid" height="30" width="30">';
									}
									if($calciatore["squalificatoSN"]=='S'){
										echo '<img src="./images/Default/rosso.png" alt="espulso" height="30" width="30">';
									} 
									if($calciatore["prob_giocare"]<=30 && $calciatore["infortunatoSCN"]=='N' && $calciatore["squalificatoSN"]=='N'){
										echo '<div class="progress prob_giocare position-relative"><div class="progress-bar" style="width:'.$calciatore["prob_giocare"].'%; background-color: lightgray; color:black;"><small class="justify-content-center d-flex position-absolute w-100">'.$calciatore["prob_giocare"].'%</small></div></div>';
									} else if($calciatore["prob_giocare"]>30 && $calciatore["prob_giocare"]<70 && $calciatore["infortunatoSCN"]=='N' && $calciatore["squalificatoSN"]=='N'){
										echo '<div class="progress prob_giocare position-relative"><div class="progress-bar" style="width:'.$calciatore["prob_giocare"].'%; background-color: orange; color:black;"><small class="justify-content-center d-flex position-absolute w-100">'.$calciatore["prob_giocare"].'%</small></div></div>';
									} else if($calciatore["infortunatoSCN"]=='N' && $calciatore["squalificatoSN"]=='N'){
										echo '<div class="progress prob_giocare position-relative"><div class="progress-bar" style="width:'.$calciatore["prob_giocare"].'%; background-color: rgb(21, 221, 21); color:black;"><small class="justify-content-center d-flex position-absolute w-100">'.$calciatore["prob_giocare"].'%</small></div></div>';
									}
									echo '</div></li>';
								}
							?>
						</ul>
					
				</div>
				<div>
					<br>
					<div class="dropdown my-menu">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php 
						if(empty($_GET["id_modulo"])){
							$_GET["id_modulo"]="13";
						}
							$modulo = Fantacalcio::getModulo($_GET["id_modulo"]);
							echo $modulo["numero_difensori"].'-'.$modulo["numero_centrocampisti"].'-'.$modulo["numero_attaccanti"];
							$id_moduli = Fantacalcio::getIdModuliConsentiti($_SESSION["id_fantalega"]);
						?>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<?php
						foreach($id_moduli as $id_modulo){
							$opzione_modulo = Fantacalcio::getModulo($id_modulo);
							echo ' <a class="dropdown-item" href="./InserisciFormazione.php?id_modulo='.$id_modulo.'">'.$opzione_modulo["numero_difensori"].'-'.$opzione_modulo["numero_centrocampisti"].'-'.$opzione_modulo["numero_attaccanti"].'</a>';  
							}
							?>
						</div>
					</div>
					<br>
					<form method="POST" action="./CheckInserisciFormazione.php">
						<input type="number" name="id_modulo" value="<?php echo($_GET["id_modulo"]) ?>" hidden>
						<input type="number" name="numero_giornata" value="<?php echo(Fantacalcio::getNumeroNextGiornata()) ?>" hidden>
						<div class="row">
							<article id="dropItTitolari" style="background-color: rgba(255, 166, 0, 0.555);" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'portiere')" ondragover="return dragOver(event)"></article>
						</div>
						<br>
						<div class="row">
							<?php
								for($i=0;$i<$modulo["numero_difensori"];$i++){
									echo '<div class="col-sm">';
										echo '<article id="dropItTitolari" style="background-color: rgba(0, 128, 0, 0.555);" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'."'"."difensore'".')" ondragover="return dragOver(event)"></article>';
									echo '</div>';
								}
							?>
						</div>
						<br>
						<div class="row">
							<?php
								for($i=0;$i<$modulo["numero_centrocampisti"];$i++){
									echo '<div class="col-sm">';
										echo '<article id="dropItTitolari" style="background-color: rgba(0, 0, 128, 0.555); ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'."'"."centrocampista'".')" ondragover="return dragOver(event)"></article>';
									echo '</div>';
								}
							?>
						</div>
						<br>
						<div class="row">
							<?php
								for($i=0;$i<$modulo["numero_attaccanti"];$i++){
									echo '<div class="col-sm">';
										echo '<article id="dropItTitolari" style="background-color: rgba(128, 0, 0, 0.555); ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'."'"."attaccante'".')" ondragover="return dragOver(event)"></article>';
									echo '</div>';
								}
							?>
						</div>
						<h1 class="text-center">Panchina:</h1>
						<div class="row">
							<div class="col-sm">
								<article id="dropItPanchinari" style="background-color: rgba(255, 166, 0, 0.555);" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'portiere')" ondragover="return dragOver(event)"></article>
							</div>
							<?php
								for($i=0;$i<3;$i++){
									echo '<div class="col-sm">';
										echo '<article id="dropItPanchinari" style="background-color: rgba(0, 128, 0, 0.555);"  ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'."'"."difensore'".')" ondragover="return dragOver(event)"></article>';
									echo '</div>';
								}
							?>
							<div class="col-sm">
								<article id="dropItPanchinari" style="background-color: rgba(0, 0, 128, 0.555);" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'centrocampista')" ondragover="return dragOver(event)"></article>
							</div>
						</div>
						<br>
						<div class="row">
							<?php
								for($i=0;$i<2;$i++){
									echo '<div class="col-sm">';
										echo '<article id="dropItPanchinari" style="background-color: rgba(0, 0, 128, 0.555);" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'."'"."centrocampista'".')" ondragover="return dragOver(event)"></article>';
									echo '</div>';
								}
								for($i=0;$i<3;$i++){
									echo '<div class="col-sm">';
										echo '<article id="dropItPanchinari" style="background-color: rgba(128, 0, 0, 0.555); ondragenter="return dragEnter(event)" ondrop="return dragDrop(event,'."'"."attaccante'".')" ondragover="return dragOver(event)"></article>';
									echo '</div>';
								}
							?>
						</div>
						<br>
						<div class="row">
							<div class="col text-center">
								<a type="button" href="./AreaFantallenatore.php" class="btn btn-secondary">Torna indietro</a>
							</div>
							<div class="col text-center">
								<a type="button" href="./InserisciFormazione.php?id_modulo=<?php echo $modulo["id_modulo"] ?>" class="btn btn-dark">Svuota formazione</a>
							</div>
							<div class="col text-center">
								<button type="submit" class="btn btn-primary">Inserisci formazione</button>
							</div>
						</div>
						<div id="test"></div>
					</form>
				</div>
			</div>
		  
			
		  
		
		</section><!-- /#html5-drag -->
	</body>
</html>