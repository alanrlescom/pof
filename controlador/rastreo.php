<?php

include "./conexion.php";

function obtenerDireccion($id, mysqli $conn) {
    $query = "SELECT * FROM direccion WHERE id=$id";
    $result = $conn->query($query);
    if ($result == FALSE) {
        echo $conn->error;
    }
    return $result->fetch_array();
}

function obtenerContacto($id, mysqli $conn) {
    $query = "SELECT * FROM contacto WHERE id=$id";
    $result = $conn->query($query);
    if ($result == FALSE) {
        echo $conn->error;
    }
    return $result->fetch_assoc();
}

$id = $_POST["id"];

$query = "SELECT * FROM envio WHERE id=$id";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $origen = obtenerDireccion($row["origen"], $conn);
    $destino = obtenerDireccion($row["destino"], $conn);
    $remitente = obtenerContacto($row["remitente"], $conn);
    $destinatario = obtenerContacto($row["destinatario"], $conn);

    send_response(200, "ok", array(
        "envio" => $row,
        "origen" => $origen,
        "destino" => $destino,
        "remitente" => $remitente,
        "destinatario" => $destinatario,
        "mismaCuenta" => isset($_SESSION["id_cliente"]) ? $row["id_cliente"] == $_SESSION["id_cliente"] : FALSE,
    ));
    

} else {
    send_response(500, "No existe un envio con este numero de guia", "");
}

?>