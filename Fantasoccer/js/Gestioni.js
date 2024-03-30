function updateTextInput(val) {
    document.getElementById('textInput').value=val+'%'; 
}

function passDataCalciatore($id) {
    var str = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="button" onclick="'+
    "location.href='./deleteCalciatore.php?id_calciatore="+$id+'\'" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str;
}

function passDataModulo($id) {
    var str = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="button" onclick="'+
    "location.href='./deleteModulo.php?id_modulo="+$id+'\'" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str;
}

function passDataPartita($numero_giornata,$id_casa,$id_ospite) {
    var str = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="button" onclick="'+
    "location.href='./deletePartita.php?numero_giornata="+$numero_giornata+'&id_squadra_serieA_casa='+$id_casa+'&id_squadra_serieA_trasferta='+$id_ospite+'\'" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str;
}

function passDataSquadra($id) {
    var str = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="button" onclick="'+
    "location.href='./deleteSquadra.php?id_squadra_serieA="+$id+'\'" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str;
}

function passDataPagellista($id) {
    var str = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="button" onclick="'+
    "location.href='./deletePagellista.php?id_pagellista="+$id+'\'" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str;
}

function passDataBonus($id) {
    var str = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="button" onclick="'+
    "location.href='./deleteBonus.php?id_bonus="+$id+'\'" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str;
}

function set_file(e) {
    e.preventDefault();
    document.getElementById('selectfile').files=e.dataTransfer.files;
}

function newImage($type){
    var str = '<div class="form-group"><label for="inputImage">Nuov'+$type+'</label><div id="drop_file_zone" ondrop="set_file(event)" ondragover="return false"><div id="drag_upload_file"><br><p>Lascia il file qui</p><p>oppure</p><p><input type="file" name="image" id="selectfile"></p></div></div></div>';
    document.getElementById("imageDiv").innerHTML=str;
}