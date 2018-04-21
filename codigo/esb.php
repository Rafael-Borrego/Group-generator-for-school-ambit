<?php
    //Capturamos la variable que nos indica a donde debemos dirigirnos
    if(!empty($_GET["r"]))
        $r = $_GET["r"];
    else $r = null;
    switch($r){

        //Si se le pasa la variable home
        case 'home':
            include('../index.php');
        break;
        //Si se le pasa la varible crearGrupos
        case 'crearGrupos':
            include('crearGrupos.php');
        break;
        //Si se le pasa la variable alumnos
        case 'alumnos':
            include ("alumnos.php");
        break;
        case 'error':
            include("errorJson.php");
        break;
        //Si se le pasa otro valor distinto o la variable no existe
        default:
            header('Location: ../index.php');
        break;
    }
?>