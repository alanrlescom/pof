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
    <title>Inicia sesión | POF</title>
    <link rel="shortcut icon" href="img/tw.png" type="image/x-icon" />

    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/login.alt.css" />
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
        <form action="./controlador/validarCliente.php" method="post" id="createForm">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Iniciar Sesión</span>
                </div>
                <div class="card-body">
                    <div class="column">
                        <div class="input-field">
                            <label for="email">Correo electrónico</label>
                            <input required type="email" name="email" id="email" placeholder="alguien@ejemplo.com"
                                autocomplete="off" />
                        </div>

                    </div>
                    <div class="column">
                        <div class="input-field">
                            <label for="password">Contraseña</label>
                            <input required type="password" name="password" id="password" placeholder="Contraseña"
                                autocomplete="off" />
                        </div>
                    </div>
                    <div class="column">
                        <div class="send-button-container">
                            <input type="hidden" name="token" id="token" value="" >
                            <div class="g-recaptcha" data-sitekey="6LewmVgdAAAAAJAdiIZ4SErczM86M1zH_yxof0dC" data-callback="onCaptcha" data-expired-callback="expiredCaptcha"></div>
                            <button class="send-button" type="submit" id="sendButton">Entrar</button>
                            <a href="./crearCuenta.php">
                                Crea tu cuenta aquí
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="forgot-password">
                ¿Has olvidado tu contraseña?
            </a>
        </form>
    </main>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/login.js"></script>
</body>

</html>