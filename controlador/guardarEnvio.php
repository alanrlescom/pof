<?php

    include "./conexion.php";

    function guardarDireccion($direccion, mysqli $conn) {
        $cp = $direccion["cp"];
        $colonia = $direccion["colonia"];
        $calle = $direccion["calle"];
        $numero = $direccion["numero"];
        $estado = $direccion["estado"];
        $municipio = $direccion["municipio"];

        $query = "INSERT INTO direccion(cp,colonia,calle,numero,estado,municipio) VALUES ('$cp', '$colonia', '$calle', '$numero', '$estado', '$municipio')";
        $result = $conn->query($query);
        if ($result == FALSE) {
            echo $conn->error;
        }
        return $conn->insert_id;
    }

    function guardarContacto($direccion, mysqli $conn) {
        $nombre = $direccion["nombre"];
        $telefono = $direccion["telefono"];
        $email = $direccion["email"];

        $query = "INSERT INTO contacto(nombre, telefono, email) VALUES ('$nombre', '$telefono', '$email')";
        $result = $conn->query($query);
        if ($result == FALSE) {
            echo $conn->error;
        }
        return $conn->insert_id;
    }

    $envio = json_decode($_POST["envio"], true);
    $cotizacion = json_decode($_POST["cotizacion"], true);

    $origen = $envio['origen'];
    $destino = $envio['destino'];

    $id_origen = guardarDireccion($origen, $conn);
    $id_destino = guardarDireccion($destino, $conn);
    $remitente = guardarContacto($origen, $conn);
    $destinatario = guardarContacto($destino, $conn);
    $size = $cotizacion["pesoVolumetrico"];
    $peso = $envio["peso"];
    $recoleccion = $envio["recoleccion"];
    $costo = $cotizacion["costo"];
    $fechaLlegada = $cotizacion["fecha"];
    $id_cliente = $_SESSION["id_cliente"];

    $query = "INSERT INTO envio(id_cliente,origen, remitente, destino, destinatario, size, peso, recoleccion, costo, fecha_llegada) VALUES ($id_cliente, $id_origen, $remitente, $id_destino, $destinatario, '$size', '$peso', '$recoleccion', '$costo', '$fechaLlegada')";
    $result = $conn->query($query);
    if ($result == FALSE) {
        echo $conn->error;
    }
    $id = $conn->insert_id;
    if ($result) {
        echo $conn->error;
    }

    send_response(200, "ok", array(
        "id" => $id
    ));

    
?>