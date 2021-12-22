<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Cotizar envío | POF</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="./css/styles.css" />
	<link rel="stylesheet" href="./css/cotizar.css" />
	<script src="https://js.stripe.com/v3"></script>
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
			<div :class="'card ' +( step === 0 ? '' : ' bg-white')">
				<div class="card-header">
					<span class="card-title">
						{{ title[step] }}
					</span>
					<div class="spacer"></div>
					<div class="card-subtitle">{{ subtitle[step] }}</div>
				</div>
				<div class="card-body" v-if="step === 0">
					<div class="flex flex-column gap-2">
						<div class="flex gap-1">
							<div class="form-field">
								<label for="categoria">
									Tamaño del paquete :
								</label>
								<select id="categoria" v-model="envio.categoria">
									<option :value="0">
										Sobre para documentos
									</option>
									<option :value="1">
										Caja pequeña (15cm x 15cm x 15cm)
									</option>
									<option :value="2">
										Caja mediana (25cm x 25cm x 25cm)
									</option>
									<option :value="3">
										Caja grande (40cm x 40cm x 40cm)
									</option>
								</select>
							</div>
							<div class="form-field">
								<label for="peso">Peso en Kg (Peso máximo: 50 kg) : </label>
								<input id="peso" type="number" v-model="envio.peso" />
							</div>
						</div>
						<div class="flex gap-1">
							<div class="form-field">
								<label for="recoleccion">Opciones de recolección y entrega</label>
								<select id="recoleccion" v-model="envio.recoleccion">
									<option v-for="tipo in tiposRecoleccion" :value="tipo.value">
										{{ tipo.label }}
									</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body" v-if="step === 0">
					<div class="flex flex-column gap-2">
						<div
							:class="'flex flex-column gap-2 ' + ([1,2,3].includes(envio.recoleccion) ? 'flex-column' : 'flex-row')">
							<div class="flex flex-column flex-1">
								<div class="column-header">Remitente</div>
								<div class="flex flex-column gap-1" v-if="[2,3].includes(envio.recoleccion)">
									<div class="form-field inline">
										<label for="sucursal">Sucursal:</label>
										<select id="sucursal" v-model="envio.origen.sucursal">
											<option v-for="sucursal in sucursales" :value="sucursal.value">
												{{ sucursal.label }}
											</option>
										</select>
									</div>
								</div>
								<div class="flex flex-column gap-2" v-else>
									<div class="form-field inline">
										<label for="origencp">Código postal:</label>
										<div class="form-field inline addons">
											<input type="text" v-model="envio.origen.cp" if="origencp" maxlength="5"
												@blur="consultarCodigoPostal(envio.origen)" />
											<button class="btn btn-secondary btn-outline"
												:disabled="envio.origen.cp === ''" @click="consultarCodigoPostal(envio.origen)">
												Consultar
											</button>
										</div>
									</div>
									<div class="form-field inline">
										<label for="origenestado">Estado:</label>
										<select id="origenestado" v-model="envio.origen.estado">
											<option v-for="estado in estados" :value="estado">
												{{ estado }}
											</option>
										</select>
									</div>
									<div class="form-field inline">
										<label for="origenmunicipio">Alcaldía/Municipio</label>
										<input type="text" id="origenmunicipio" v-model="envio.origen.municipio">
									</div>
									<div class="form-field inline">
										<label for="origencolonia">Colonia:</label>
										<input v-if="!envio.origen.colonias" type="text" id="origencolonia"
											v-model="envio.origen.colonia" />
										<select v-else id="origencolonia" v-model="envio.origen.colonia">
											<option v-for="colonia in envio.origen.colonias" :value="colonia">
												{{ colonia }}
											</option>
										</select>
									</div>
									<div class="form-field inline">
										<label for="origencalle">Calle:</label>
										<input type="text" id="origencalle" v-model="envio.origen.calle" />
									</div>
									<div class="form-field inline">
										<label for="origennumero">Número:</label>
										<input id="origennumero" type="text" v-model="envio.origen.numero" />
									</div>
								</div>
							</div>
							<div class="flex flex-column flex-1">
								<div class="column-header">
									Destinatario
								</div>
								<div class="flex flex-column gap-1" v-if="[1,3].includes(envio.recoleccion)">
									<div class="form-field inline">
										<label for="sucursal">Sucursal:</label>
										<select id="sucursal" v-model="envio.destino.sucursal">
											<option v-for="sucursal in sucursales" :value="sucursal.value">
												{{ sucursal.label }}
											</option>
										</select>
									</div>
								</div>
								<div class="flex flex-column gap-2" v-else>
									<div class="form-field inline">
										<label for="destinocp">Código postal:</label>
										<div class="form-field inline addons">
											<input type="text" v-model="envio.destino.cp" if="destinocp" maxlength="5"
												v-on:blur="consultarCodigoPostal(envio.destino)" />
											<button class="btn btn-secondary btn-outline"
												:disabled="envio.destino.cp === ''" @click="consultarCodigoPostal(envio.destino)">
												Consultar
											</button>
										</div>
									</div>
									<div class="form-field inline">
										<label for="destinoestado">Estado:</label>
										<select id="destinoestado" v-model="envio.destino.estado">
											<option v-for="estado in estados" :value="estado">
												{{ estado }}
											</option>
										</select>
									</div>
									<div class="form-field inline">
										<label for="destinomunicipio">Alcaldía/Municipio</label>
										<input type="text" id="destinomunicipio" v-model="envio.destino.municipio">
									</div>
									<div class="form-field inline">
										<label for="destinocolonia">Colonia:</label>
										<input v-if="!envio.destino.colonias" type="text" id="destinocolonia"
											v-model="envio.destino.colonia" />
										<select v-else id="destinocolonia" v-model="envio.destino.colonia">
											<option v-for="colonia in envio.destino.colonias" :value="colonia">
												{{ colonia }}
											</option>
										</select>
									</div>
									<div class="form-field inline">
										<label for="destinocalle">Calle:</label>
										<input type="text" id="destinocalle" v-model="envio.destino.calle" />
									</div>
									<div class="form-field inline">
										<label for="destinonumero">Número:</label>
										<input id="destinonumero" type="text" v-model="envio.destino.numero" />
									</div>
								</div>
							</div>
						</div>
						<div class="flex justify-end gap-2">
							<button class="btn btn-secondary" @click="cancelar">
								Cancelar
							</button>
							<button class="btn btn-primary" @click="cotizar">
								Cotizar
							</button>
						</div>
					</div>
				</div>
				<div class="card-body" v-if="step === 1">
					<div class="flex flex-column">
						<div class="flex">
							<div class="flex spacer">
								<div class="flex align-center">
									<img src="https://cdn-icons-png.flaticon.com/512/709/709790.png" alt="img"
										style="height: 10rem; height: 10rem">
									<div class="flex flex-column gap-1 spacer date">
										<div class="date-main">
											{{ mostrarFecha(cotizacion.fecha) }} <span class="subtitle">| a más tardar al
												final del día</span>
										</div>
										<span class="subtitle">
											Las fechas de llegada están sujetas a disponibilidad
										</span>
									</div>
								</div>
							</div>
							<div class="flex">
								<div class="total">
									<span class="title">
										${{ cotizacion.costo }}MXN
									</span>
									<span class="subtitle">
										~ {{ cotizacion.distancia }} Km
									</span>
									<span class="subtitle">
										Peso volumetrico: {{ cotizacion.pesoVolumetrico }}
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="flex justify-end gap-2">
						<button class="btn btn-secondary" @click="prevStep">
							Regresar
						</button>
						<button class="btn btn-primary" @click="realizarEnvio(<?php echo isset($_SESSION["email"]) ? 1 : 0; ?>)">
							<?php echo isset($_SESSION["email"]) ? "Realizar envío" : "Inicia sesión para realizar el envio"; ?>
						</button>
					</div>
				</div>
				<div class="card-body" v-if="step === 2">
					<form class="flex flex-column gap-2" id="payment-form" @submit="guardarEnvio">
						<div class="flex flex-grow-1 flex-row gap-2">
							<div class="flex flex-1 flex-column gap-2">
								<div class="column-header">
									Remitente
								</div>
								<div class="form-field inline">
									<label>Su nombre completo*:</label>
									<input type="text" v-model="envio.origen.nombre" />
								</div>
								<div class="form-field inline">
									<label>Teléfono*:</label>
									<input type="text" v-model="envio.origen.telefono">
								</div>
								<div class="form-field inline">
									<label>Correo electrónico (opcional):</label>
									<input type="text" v-model="envio.origen.email">
								</div>
							</div>
							<div class="flex flex-1 flex-column gap-2">
								<div class="column-header">
									Destinatario
								</div>
								<div class="form-field inline">
									<label>Nombre completo*:</label>
									<input type="text" v-model="envio.destino.nombre" />
								</div>
								<div class="form-field inline">
									<label>Teléfono*:</label>
									<input type="text" v-model="envio.destino.telefono">
								</div>
								<div class="form-field inline">
									<label>Correo electrónico (opcional):</label>
									<input type="text" v-model="envio.destino.email">
								</div>
							</div>
						</div>
						<div class="column-header">
							Datos bancarios
						</div>
						<div id="payment-element">
							<!--Stripe.js injects the Payment Element-->
						</div>
						<div class="flex flex-row justify-end gap-2">
							<button class="btn btn-secondary" @click="prevStep">
								Regresar
							</button>
							<button id="submit" type="submit" class="btn btn-primary">
								<span id="button-text">Pagar</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<script src="./js/scripts.js?t=<?php echo md5_file("./js/scripts.js");?>"></script>
	<script src="./js/vue/cotizar.js?t=<?php echo md5_file("./js/vue/cotizar.js");?>"></script>
</body>

</html>