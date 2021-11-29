<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pack On Fire</title>

    <link rel="shortcut icon" href="img/tw.png" type="image/x-icon">

    <link rel="stylesheet" href="css/restablecer.css">

</head>


<body class="align">

    <div class="login">

        <header class="login__header">
            <h2>Restablecer Contraseña</h2>
        </header>

        <form action="restablecercontraseña2.php" class="login__form" method="POST">
            <div>
                <label>Ingresa la direccion de correo electronico con la que te 
                registraste en el sistema, te enviaremos el enlace para restablecer 
                tu contraseña.</label>
            </div>
            <div>
                <label for="email">Correo Electronico</label>
                <input type="email" id="email" name="email" placeholder="alguien@ejemplo.com">
            </div>

            <div>
                <a href="login.html"><input class="buttonini" type="button" value="Iniciar Sesión"></a>
                <input class="button" type="submit" value="Enviar">
            </div>

        </form>

    </div>

</body>

</html>