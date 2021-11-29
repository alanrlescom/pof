<?php
$email = $_POST['email'];
?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pack On Fire</title>

    <link rel="shortcut icon" href="img/tw.png" type="image/x-icon">

    <link rel="stylesheet" href="css/restablecer2.css">

</head>


<body class="align">

    <div class="login">

        <header class="login__header">
            <h2>Restablecer Contraseña</h2>
        </header>

            <div class="login__form" method="POST">
                <div class="login__label">
                    <label>Hemos enviado la información para restablecer contraseña
                        al correo electronico.
                    </label>
                    <br><br>
                    <label style="text-align: center;"><?php echo "$email"  ?></label><br>
                    <div>
                    <a href="login.html"><input class="buttonini" type="submit" value="Aceptar"></a>
                    </div>
                </div>
                
            </div>

    </div>

</body>

</html>