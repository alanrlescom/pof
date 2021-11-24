<?php

session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Registrate | POF</title>
	<link rel="shortcut icon" href="img/tw.png" type="image/x-icon" />

	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/registrarCliente.css" />
</head>

<body>
	<nav class="navbar">
		<a href="./index.php" class="nav-link"> Pack On Fire </a>
	</nav>
	<main class="register-container">
		<form action="./controlador/registrarCliente.php" method="post" id="createForm">
			<div class="card">
				<div class="card-header">
					<span class="card-title">Crear Cuenta</span>
				</div>
				<div class="card-body">
					<div class="column">
						<div class="input-field">
							<label for="nombre">Nombre*</label>
							<input required type="text" name="nombre" id="nombre" placeholder="Nombre"
								autocomplete="off" />
						</div>
						<div class="input-field">
							<label for="apellido">Apellido*</label>
							<input required type="text" name="apellido" id="apellido" placeholder="Apellido"
								autocomplete="off" />
						</div>
					</div>
					<div class="column">
						<div class="input-field">
							<label for="email">Correo electrónico*</label>
							<input required type="email" name="email" id="email" placeholder="alguien@ejemplo.com"
								autocomplete="off" />
						</div>
						<div class="input-field">
							<label for="password">Contraseña*</label>
							<input required type="password" name="password" id="password" placeholder="Contraseña"
								autocomplete="off" />
						</div>
					</div>
					<div class="column">
						<div class="input-field">
							<label for="confirmEmail">Confirmar correo</label>
							<input type="email" name="confirmEmail" id="confirmEmail" placeholder="alguien@ejemplo.com"
								autocomplete="off" />
						</div>
						<div class="input-field">
							<label for="confirmPassword">Confirmar contraseña</label>
							<input type="password" name="confirmPassword" id="confirmPassword"
								placeholder="Confirmar contraseña" autocomplete="off" />
						</div>
					</div>
					<div class="column">
						<div class="input-field">
							<label for="phone">Teléfono*</label>
							<input required type="tel" name="phone" id="phone" placeholder="Teléfono"
								autocomplete="off" />
						</div>
						<div class="input-field">
							<label for="rfc">RFC</label>
							<input type="text" name="rfc" id="rfc" placeholder="RFC" autocomplete="off" />
						</div>
					</div>
					<div class="column">
						<div class="send-button-container">
							<button class="send-button" type="submit" id="sendButton">Crear</button>
							<a href="./login.php">
								¿Tienes cuenta? Inicia sesion aquí
							</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</main>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="js/registarCliente.js"></script>
</body>

</html>