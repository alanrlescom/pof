<?php

session_start();

function mandarError($err) {
    header("Location: ../login.php?err=" . $err);
}

$secretoReCatpcha = "6LewmVgdAAAAAFin3oDZQgqgjRJytqRNj6fZJ8hF";

$token = $_POST["token"];
$email = $_POST["email"];
$password = $_POST["password"];

// Peticion de validacion de token
$postdata = http_build_query(
    array(
        'secret' => $secretoReCatpcha,
        'response' => $token
    )
);
$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context = stream_context_create($opts);
$result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);

if ($result != FALSE) {
    $jsonResult = json_decode($result, true);
    if ($jsonResult["success"]) {
        $connection = new mysqli("localhost", "adminpof", "c0ncu1d4d0yd3d4l3sl0busc4n", "pof");

        $query = "SELECT * FROM cliente WHERE correo='$email'";
        $result = $connection->query($query);
        if ($result) {
            if ($result->num_rows < 1) {
                mandarError(1); // correo o password incorrectos
            } else {
                // Valida la existencia del correo
                $query = "SELECT * FROM cliente WHERE correo='$email' AND password=MD5('$password')";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_array();
                    $_SESSION["email"] = $email;
                    $_SESSION["nombre"] = $row["nombre"];
        
                    $connection->close();
                    header("Location: ../index.php");
                } else {
                    $connection->close();
                    mandarError(1); 
                }
        
            }
        } else {
            $connection->close();
            mandarError(2); // Error con la bd
        }
    } else {
        mandarError(3);
    }
} else {
    mandarError(3);
}


?>