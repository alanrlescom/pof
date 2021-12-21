<?php
    include "./conexion.php";
    
    $id = $_POST["id"];
    $query = "DELETE FROM envios WHERE id=$id";
    $result = $conn->query($query);
    if ($result == FALSE) {
        send_response(500, "Ocurrio un error eliminando el envio", $conn->error);
    } else {
        send_response(200, "ok", "");
    }
?>