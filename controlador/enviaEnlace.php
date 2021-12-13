<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

function mandarError($err, $connection) {
    $connection->close();
    header("Location: ../solicitarRestablecer.php?err=" . $err);
}

$email = $_POST["email"];

$connection = new mysqli("localhost", "adminpof", "c0ncu1d4d0yd3d4l3sl0busc4n", "pof");

$query = "SELECT * FROM cliente WHERE correo='$email'";
$result = $connection->query($query);
if ($result) {
    if ($result->num_rows < 1) {
        mandarError(1, $connection); // No esta registrado el correo
    } else {
        $row = $result->fetch_array();
        $id_cliente = $row["id_cliente"];
        $key = md5(date('m/d/Y h:i:s a', time()));

        $query = "DELETE FROM solicitudes_restablecimiento WHERE id_cliente=$id_cliente";
        $connection->query($query);
        
        $query = "INSERT INTO solicitudes_restablecimiento(clave, id_cliente) VALUE ('$key', $id_cliente)";
        $result = $connection->query($query);
        $connection->close();

        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Username   = 'alanrl.escom@gmail.com';
            $mail->Password   = '414nr0m3r0luc3r0';
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true; 
            $mail->Host = "smtp.gmail.com"; 
            $mail->Port = 465;

            //Recipients
            $mail->setFrom('alanrl.escom@gmail.com', 'POF');
            $mail->addAddress($email, $email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pack On Fire - Restablecimiento de contraseña';
            $mail->Body    = 'Has click en el siguiente enlace para restablecer tu contraseña: <br><b><a href="https://216.238.74.227/pof/restablecer.php?key=' . $key . '">Restablecer contraseña</a></b>';

            echo var_dump($mail->send());
        } catch (Exception $e) {
            // mandarError(2, $connection);
            echo $e->getMessage();
        }

        // header("Location: ../emailEnviado.php?email=$email");
    }
} else {
    echo $connection->error;
    // mandarError(2, $connection); // Error con la bd
}
// $connection->close();


?>