<?php

session_start();

function mandarError($err) {
    header("Location: ../login.php?err=" . $err);
}

$email = $_POST["email"];
$password = $_POST["password"];

$connection = new mysqli("localhost", "root", "", "pof");

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
            mandarError(1); // correo o password incorrectos
        }

    }
} else {
    $connection->close();
    mandarError(2); // Error con la bd
}
$connection->close();


?>