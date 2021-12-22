<?php
    include "./conexion.php";
    
    $query = "SELECT * FROM sucursal";
    $result = $conn->query($query);
    if ($result != FALSE) {
        echo $conn->error;
    }
    $array = array();
    while ($row = $result->fetch_assoc()) {
        $array[] = $row;
    }
    echo var_dump($array);
    // send_response(200, "ok", $array);
    
    $conn->close();
?>