<?php

session_start();
$conn = new mysqli("localhost", "adminpof", "c0ncu1d4d0yd3d4l3sl0busc4n", "pof");

function send_response($status, $message, $extra) {
    echo json_encode(array(
        "status" => $status,
        "message" => $message,
        "extra" => $extra
    ));
}

?>