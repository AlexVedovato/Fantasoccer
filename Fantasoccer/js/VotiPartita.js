function controllaSelezione(id_click,id_altro){
    if(document.getElementById(id_click).checked){
        if(document.getElementById(id_altro).checked){
            document.getElementById(id_altro).checked=false;
        }
    }
}