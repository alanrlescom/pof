<?php

session_start();

function mandarError($err, $connection) {
    $connection->close();
    header("Location: ../solicitarReestablecer.php?err=" . $err);
}

$email = $_POST["email"];

$connection = new mysqli("localhost", "root", "", "pof");

$query = "SELECT * FROM cliente WHERE correo='$email'";
$result = $connection->query($query);
if ($result) {
    if ($result->num_rows < 1) {
        mandarError(1, $connection); // No esta registrado el correo
    } else {
        $row = $result->fetch_array();
        $id_cliente = $row["id_cliente"];
        $key = md5(date('m/d/Y h:i:s a', time()));

        $query = "DELETE FROM solicitudes_reestablecimiento WHERE id_cliente=$id_cliente";
        $connection->query($query);
        
        $query = "INSERT INTO solicitudes_reestablecimiento(clave, id_cliente) VALUE ('$key', $id_cliente)";
        $result = $connection->query($query);
        $connection->close();
        header("Location: ../emailEnviado.php?email=$email");
    }
} else {
    mandarError(2, $connection); // Error con la bd
}
$connection->close();


?>