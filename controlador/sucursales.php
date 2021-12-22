<?php
    include "./conexion.php";
    
    try {
        $query = "SELECT * FROM sucursal";
    $result = $conn->query($query);
    if ($result != FALSE) {
        echo $conn->error;
    }
    $array = array();
    while ($row = $result->fetch_assoc()) {
        array_push($array, $row);
    }
    send_response(200, "ok", $array);
    
    } catch(Exception $e) {
        echo $e->getMessage();
    }
    $conn->close();
?>