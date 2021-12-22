<?php

session_start();

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pack On Fire</title>

    <link rel="shortcut icon" href="img/tw.png" type="image/x-icon">

    <link rel="stylesheet" href="css/estilos.css">

</head>

<body>

    <header>

        <nav>
            <a href="./index.php">Inicio</a>
            <a href="./cotizar.php">Enviar</a>
            <a href="./rastreo.php">Rastreo</a>
            <?php if (!isset($_SESSION["email"])) {?>
            <a href="login.php" class="button3">Iniciar Sesion/Registrate</a>
            <?php } else { ?>
            <a href="" class="usuario"><?php echo $_SESSION["nombre"]?></a>
            <a href="./controlador/logout.php" class="button3">logout</a>
            <?php } ?>

        </nav>

        <section class="textos-header">

            <h1>Rastree Su Envio</h1>
            <br>
            <br>

            <div class="center">
                <form method="GET" action="./rastreo.php">
                    <div class="inputbox">
                        <input type="text" required="required" name="guia">
                        <span>Introduzca su numero de ID para rastrear</span>
                    </div>
                    <button href="./rastreo.php" class="button1" type="submit">Rastrear</butt>
                </form>
            </div>
            <br>
            <br>
            <br>
            <h2>O cotice con nosotros</h2>
            <a href="./cotizar.php" class="button2">Cotizar</a>

        </section>
    </header>

    <main>

        <section class="contenedor sobre nosotros">

            <h2 class="titulo">Nuestras Sucursales</h2>

            <div class="map-responsive">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3760.8711293502824!2d-99.14890564881205!3d19.504179486779236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f94c06d75fd7%3A0x3fe1567da2190ac9!2sESCOM%20-%20Escuela%20Superior%20de%20C%C3%B3mputo%20-%20IPN!5e0!3m2!1ses-419!2smx!4v1637787970763!5m2!1ses-419!2smx"
                    width="1000" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

            </div>

        </section>

        <section class="about-services">

            <div class="contenedor">

                <h2 class="titulo">Nuestros servicios</h2>

                <div class="servicio-cont">

                    <div class="servicio-ind">
                        <img src="img/img2.svg" alt="">
                        <h3>Objetivo</h3>
                        <p>Brindar servicios competitivos de mensajería y paquetería, con prácticas confables, procesos de excelencia y calidad en los productos y servicios.</p>
                    </div>

                    <div class="servicio-ind">
                        <img src="img/img3.svg" alt="">
                        <h3>Envios Nacionales</h3>
                        <p>En PackOnFire te podemos realizar todos tus envíos a cualquier destino dentro de la republica mexicana</p>
                    </div>

                    <div class="servicio-ind">
                        <img src="img/img4.svg" alt="">
                        <h3>Servicio</h3>
                        <p>¿Necesitas un servicio de paquetería o mensajería? Realiza tu envío con PackOnFire
                            Calculamos la mejor ruta, entregas garantizadas y servicio de calidad</p>
                    </div>

                </div>

            </div>


        </section>
    </main>

    <footer>
        <div class="contenedor-footer">

            <div class="content-foo">
                <h4>Email</h4>
                <p>example@email.com</p>
            </div>

            <div class="content-foo">
                <h4>Direccion</h4>
                <p>Location</p>

            </div>

        </div>

    </footer>


</body>

</html>