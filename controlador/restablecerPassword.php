<?php

function mandarError($err, $connection) {
    $connection->close();
    header("Location: ../restablecer.php?err=" . $err . "&key=" . $_POST["key"]);
}

$clave = $_POST["key"];
$password = $_POST["password"];

$connection = new mysqli("localhost", "root", "", "pof");

$query = "SELECT * FROM solicitudes_restablecimiento WHERE clave='$clave' GROUP BY id_cliente";
$result = $connection->query($query);
if ($result) {
    if ($result->num_rows < 1) {
        mandarError(3, $connection); // No hay solicitud de restablecimiento
    } else {
        // Esta validado que el correo no este registrado al menos una vez
        $row = $result->fetch_array();
        $id_cliente = $row["id_cliente"];
        $query = "UPDATE cliente SET password=MD5('$password') WHERE id_cliente=$id_cliente";
        $connection->query($query);
        if ($result) {

            $connection->query("DELETE FROM solicitudes_restablecimiento WHERE id_cliente=$id_cliente");
            $connection->close();

            header("Location: ../login.php?password=1");
        } else {
            mandarError(2, $connection); // No actualizo password
        }

    }
} else {
    mandarError(2, $connection); // Error con la bd
}
$connection->close();

?>