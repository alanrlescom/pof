<?php

session_start();

if (isset($_SESSION["email"])) {
    header("Location: ./index.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restablecer contraseña | POF</title>
    <link rel="shortcut icon" href="img/tw.png" type="image/x-icon" />

    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/reestablecer.css" />
</head>

<body>
    <nav class="navbar">
        <a href="./index.php" class="nav-link"> Pack On Fire </a>
        <div class="spacer"></div>
        <a href="./index.php" class="nav-link">Inicio</a>
        <a href="#" class="nav-link">Enviar</a>
        <a href="#" class="nav-link">Rastreo</a>
    </nav>
    <main class="register-container">
        <form action="./controlador/enviaEnlace.php" method="post" id="createForm">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Restablecer contraseña</span>
                </div>
                <div class="card-body">
                    <div class="columns">
                        <p>
                            Ingresa la dirección de correo electrónico con la que te registraste en el sistema, te enviaremos el enlace para restablecer tu contraseña.
                        </p>
                    </div>
                    <div class="column">
                        <div class="input-field">
                            <label for="email">Correo electrónico</label>
                            <input required type="email" name="email" id="email" placeholder="alguien@ejemplo.com"
                                autocomplete="off" />
                        </div>
                    </div>
                    <div class="column">
                        <div class="send-button-container">
                            <a href="./login.php">Inicia sesión</a>
                            <button class="send-button" type="submit" id="sendButton">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/reestablecer.js"></script>
</body>

</html>