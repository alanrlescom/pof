<?php

function mandarError($err) {
    header("Location: ../crearCuenta.php?err=" . $err);
}

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$password = $_POST["password"];
$phone = $_POST["phone"];
$rfc = $_POST["rfc"];

$connection = new mysqli("localhost", "adminpof", "c0ncu1d4d0yd3d4l3sl0busc4n", "pof");

$query = "SELECT COUNT(*) as c FROM cliente WHERE correo='$email' GROUP BY correo";
$result = $connection->query($query);
if ($result) {
    $row = $result->fetch_array();
    if ($row["c"] > 0) {
        $connection->close();
        mandarError(1); // Ya existe el cliente con ese correo
    } else {
        // Esta validado que el correo no este registrado al menos una vez
        $query = "INSERT INTO cliente(nombre, apellido, correo, password, telefono, RFC) VALUES ('$nombre','$apellido','$email',MD5('$password'),'$phone','$rfc')";
        $result = $connection->query($query);
        if ($result) {
            $connection->close();
            header("Location: ../login.php?created=1".(isset($_POST["saveCotizacion"]) ? "&save=1" : ""));
        } else {
            $connection->close();
            mandarError(3); // No se registro el cliente
        }

    }
} else {
    $connection->close();
    mandarError(2); // Error con la bd
}
$connection->close();

?>