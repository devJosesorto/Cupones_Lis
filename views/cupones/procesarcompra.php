<?php

session_start();
//include '../db.php';

if (isset($_GET['idOferta'])) {
    $idOferta = $_GET['idOferta'];
    echo "ID de la oferta recibido: " . $idOferta;
    echo "ID USUARIO: ". $_SESSION['id_usuario'];
}else{
    echo "Error: No se ha recibido el ID de la oferta.";

}

?>
