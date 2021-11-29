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
    <title>Reestablecer contraseña | POF</title>
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
        <form onsubmit="return false;" method="post" id="createForm">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Reestablecer contraseña</span>
                </div>
                <div class="card-body">
                    <div class="card-body inner">
                        <div class="columns">
                            <p>
                                Hemos enviado la información para reestablecer tu contraseña al correo electrónico:
                            </p>
                            <p style="text-align: center; font-weight: bold;">
                                <?php echo isset($_GET["email"]) ? $_GET["email"] : "";?>
                            </p>
                        </div>
                        <div class="column">
                            <div class="send-button-container-alt">
                                <a href="./index.php" class="send-button-alt" type="submit" id="sendButton">Aceptar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>