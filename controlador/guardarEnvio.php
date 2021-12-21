<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './libraries/PHPMailer/src/Exception.php';
    require './libraries/PHPMailer/src/PHPMailer.php';
    require './libraries/PHPMailer/src/SMTP.php';
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


    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Username   = 'alanrl.escom@gmail.com';
        $mail->Password   = '414nr0m3r0luc3r0';
        $mail->SMTPSecure = 'tsl';
        $mail->SMTPAuth = true; 
        $mail->Host = "smtp.gmail.com"; 
        $mail->Port = 587;
        $mail->SMTPDebug = false;

        $mail->setFrom('alanrl.escom@gmail.com', 'POF');

        if (isset($_SESSION["email"])) {
            $mail->addAddress($_SESSION["email"], $_SESSION["email"]);
        }

        if ($origen["email"] != "") {
            $mail->addCC($origen["email"]);
        }

        if ($destino["email"] != "") {
            $mail->addCC($destino["email"]);
        }

        $mail->isHTML(true);
        $mail->Subject = 'Pack On Fire - Rastreo';
        $mail->Body    = 'Has click en el siguiente enlace para rastrear el envio: <br><b><a href="https://216.238.74.227/pof/rastreo.php?id=' . $id . '">Rastrear envio</a></b><p>O ingresa el codigo '. $id .' en la pagina de rastreo.</p>';

        $mail->send();

        send_response(200, "ok", array(
            "id" => $id
        ));

    } catch (Exception $e) {
        send_response(500, "Error enviando el correo electronico", "");
    }
    
?>