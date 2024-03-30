<?php
session_start();
if(isset($_GET["type"])){
    unset($_SESSION[$_GET["type"]]);
    if($_GET["type"]=="id_fantallenatore"){
        unset($_SESSION[$_GET["id_fantalega"]]);
        unset($_SESSION[$_GET["amministratoreSN"]]);
    }
}
header("Location: ./PaginaIniziale.html");
?>