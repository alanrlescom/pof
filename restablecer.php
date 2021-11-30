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
    <link rel="stylesheet" href="css/login.alt.css" />
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
        <form action="./controlador/restablecerPassword.php" method="post" id="newPassword">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Restablecer contraseña</span>
                </div>
                <div class="card-body">
                    <input type="hidden" name="key" value="<?php echo isset($_GET["key"]) ? $_GET["key"] : ''; ?>">
                    <div class="column">
                        <div class="input-field">
                            <label for="password">Nueva contraseña</label>
                            <input required type="password" name="password" id="password" placeholder="Contraseña"
                                autocomplete="off" />
                        </div>
                    </div>
                    <div class="column">
                        <div class="input-field">
                            <label for="confirmPassword">Confirmar contraseña</label>
                            <input required type="password" id="confirmPassword" name="confirmPassword" placeholder="Contraseña"
                                autocomplete="off" />
                        </div>
                    </div>
                    <div class="column">
                        <div class="send-button-container">
                            <button class="send-button" type="submit" id="sendButton">Restablecer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/restablecer.js"></script>
</body>

</html>