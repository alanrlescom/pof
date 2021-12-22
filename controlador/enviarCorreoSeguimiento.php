<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './libraries/PHPMailer/src/Exception.php';
    require './libraries/PHPMailer/src/PHPMailer.php';
    require './libraries/PHPMailer/src/SMTP.php';
    include "./conexion.php";

    $origen = json_decode($_POST["origen"], true);
    $destino = json_decode($_POST["destino"], true);

    $id = $_POST["id"];

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

        if ($origen["email"] != "" && $_SESSION["email"] != $origen["email"]) {
            $mail->addCC($origen["email"]);
        }

        if ($destino["email"] != "") {
            $mail->addCC($destino["email"]);
        }

        $mail->isHTML(true);
        $mail->Subject = 'Pack On Fire - Rastreo';
        $mail->Body    = 'Has click en el siguiente enlace para rastrear el envio: <br><b><a href="https://216.238.74.227/pof/rastreo.php?guia=' . $id . '">Rastrear envio</a></b><p>O ingresa el numero de guia '. $id .' en la pagina de rastreo.</p>';

        $mail->send();

        send_response(200, "ok", array(
            "id" => $id
        ));

    } catch (Exception $e) {
        send_response(500, "Error enviando el correo electronico", "");
    }
    
?>