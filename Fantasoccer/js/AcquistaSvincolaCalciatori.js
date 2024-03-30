function passDataSvincolaCalciatore($nome, $cognome, $costo_acquisto, $nome_fantasquadra, $id_fantasquadra, $id_calciatore) {
    var str = 'Sei sicuro di voler svincolare il calciatore ' + $nome + ' ' + $cognome + ' dalla fantasquadra "' + $nome_fantasquadra + '"?'
    + '<input type="number" name="id_fantasquadra" value="'+$id_fantasquadra+'" hidden>'
    + '<input type="number" name="id_calciatore" value="'+$id_calciatore+'" hidden>' + '<br>'
    + 'Crediti restituiti alla fantasquadra: ' + '<input type="number" min="1" name="costo_acquisto" class="text-center" value="'+$costo_acquisto+'">';
    document.getElementById("modal-body").innerHTML=str;
    var str2 = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="submit" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str2;
}

function passDataAcquistaCalciatore($nome, $cognome, $costo_acquisto, $nome_fantasquadra, $id_fantasquadra, $id_calciatore) {
    var str ='Sei sicuro di voler acquistare il calciatore ' + $nome + ' ' + $cognome + ' per la fantasquadra "' + $nome_fantasquadra + '"?'
    + '<input type="number" name="id_fantasquadra" value="'+$id_fantasquadra+'" hidden>'
    + '<input type="number" name="id_calciatore" value="'+$id_calciatore+'" hidden>'+ '<br>'
    + 'Costo d\'acquisto del calciatore: ' + '<input type="number" min="1" name="costo_acquisto" class="text-center" value="'+$costo_acquisto+'">';
    document.getElementById("modal-body").innerHTML=str;
    var str2 = '<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">NO</button><button type="submit" class="btn btn-primary">SI</button>';
    document.getElementById("modal-footer").innerHTML=str2;
}

