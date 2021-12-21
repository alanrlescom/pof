<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POF | Envio realizado</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="./css/styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>

<body>
    <div id="root" v-cloak>
        <nav class="navbar">
            <a href="./index.php" class="nav-link"> Pack On Fire </a>
            <div class="spacer"></div>
            <a href="./index.php" class="nav-link">Inicio</a>
            <a href="#" class="nav-link">Enviar</a>
            <a href="#" class="nav-link">Rastreo</a>
        </nav>
        <main class="flex justify-center">
            Contenido una vez realizado el envio
        </main>
    </div>
    <?php echo $_GET["id"];?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="./js/scripts.js?t=<?php echo md5_file("./js/scripts.js");?>"></script>
    <script src="./js/vue/envioRealizado.js?t=<?php echo md5_file("./js/vue/envioRealizado.js");?>"></script>
</body>

</html>
<!-- 
Para enviar el correo despues de pagar
$.post(
    './controlador/enviarCorreoSeguimiento.php',
    {
        envio: JSON.stringify(this.envio),
        cotizacion: JSON.stringify(
            this.cotizacion
        ),
        id: rguardar.extra.id,
    }
)
    .then(console.log)
    .catch(console.log);

 -->