<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pack On Fire</title>
    <link rel="shortcut icon" href="img/tw.png" type="image/x-icon">
    <link rel="stylesheet" href="css/RC3.css">
</head>

<body class="align">
    <div class="login">
    <header class="login__header">
    <h2>Restablecer Contraseña</h2>
    </header>
        <form class="login__form" name="ValidarContra" action="RC3.php"  method="Post">
        <div>
        <label for="password">Contraseña Nueva</label><br>
        <input type="password" minlength="6" name="pass" id="pass" placeholder="Contraseña">                    </div>
        <div>
        <label for="password">Confirma Contraseña</label><br>
        <input type="password" minlength="6" name="pass2" id="pass2" placeholder="Confirma Contraseña">
        </div>
        <?php
    if(isset($_POST['Enviar'])){
        $Contra=$_POST['pass'];
        $Contra2=$_POST['pass2'];
        if($Contra==$Contra2){
            header('Location: login.html');
        }else{
            echo"<div class='alert'>Las contraseñas no coinciden</div>";
        }
    }
?>
        <input class="button" type="submit" name="Enviar" value="Enviar">
        </form>
    </div>
</body>
</html>