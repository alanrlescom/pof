function errorSwal(message) {
	if (message) {
		Swal.fire({
			icon: 'error',
			text: message,
			showCancelButton: false,
			showConfirmButton: false,
			showCloseButton: true,
		});
	}
}

function successSwal(message) {
	if (message) {
		Swal.fire({
			icon: 'success',
			text: message,
			showCancelButton: false,
			showConfirmButton: false,
			showCloseButton: true,
		});
	}
}

const vue = new Vue({
	el: '#root',
	data() {
		return {
			subtitle: {
				0: '',
				1: '',
			},
			step: 0,
			cotizacion: {
				costo: '0.0',
				fecha: new Date(),
			},
			envio: {
				categoria: 0,
				peso: 0,
				recoleccion: 'sucursal',
				origen: {
					sucursal: 0,
					cp: '',
					colonia: '',
					calle: '',
					numero: '',
					nombre: '',
					estado: 'cdmx',
				},
				destino: {
					cp: '',
					colonia: '',
					calle: '',
					numero: '',
					nombre: '',
					estado: 'cdmx',
				},
			},
		};
	},
	methods: {
		cotizar() {
			const { peso } = this.envio;
			if (!peso) {
				errorSwal('Olvidó ingresar el peso del paquete.');
			}
			if (peso <= 0) {
				errorSwal('El peso no puede ser menor o igual a cero.');
				return;
			}
			if (peso > 50) {
				errorSwal('No se permiten envios con peso mayor a 50Kg.');
				return;
			}

			const { recoleccion, origen, destino } = this.envio;
			const {
				cp: ocp,
				colonia: ocolonia,
				calle: ocalle,
				numero: onumero,
				estado: oestado,
				nombre: onombre,
			} = origen;
			const { cp, colonia, calle, numero, estado, nombre } = destino;
			if (
				recoleccion !== 'sucursal' &&
				(ocp === '' ||
					ocolonia === '' ||
					ocalle === '' ||
					onumero === '' ||
					oestado === '' ||
					onombre === '')
			) {
				errorSwal(
					'Origen. Complete todos los campos de sus datos y vuelva a intentarlo por favor'
				);
				return;
			}

			if (
				cp === '' ||
				colonia === '' ||
				calle === '' ||
				numero === '' ||
				estado === '' ||
				nombre === ''
			) {
				errorSwal(
					'Destino. Complete todos los campos de sus datos y vuelva a intentarlo por favor'
				);
				return;
			}

			if (cp === '07511') {
				errorSwal('Intente con otra dirección');
				return;
			}

			const self = this;
			Swal.fire({
				title: 'Calculando',
				didOpen: () => {
					Swal.showLoading();
					setTimeout(() => {
						if (self.envio.recoleccion === 'sucursal') {
							self.consultarDireccion(self.envio.destino)
								.then((rdestino) => {
									Swal.close();
									if (
										rdestino.response.geocoding &&
										rdestino.response.geocoding[0]
									) {
										if (
											rdestino.response.geocoding[0]
												.lat &&
											rdestino.response.geocoding[0].long
										) {
											self.step = self.step + 1;
											const geocoding =
												rdestino.response.geocoding[0];
											const { lat, long } = geocoding;
											self.calcularCotizacion(
												self.getKilometros(
													lat,
													long,
													19.505,
													-99.14666667
												)
											);
										} else {
											errorSwal(
												'La calle o el número no son válidos'
											);
										}
									} else {
										errorSwal(
											'El código postal ingresado no es válido'
										);
									}
								})
								.catch((e) => {
									Swal.close();
									errorSwal(
										'El código postal ingresado no es válido'
									);
								});
						} else {
							self.consultarDireccion(self.envio.origen)
								.then((rorigen) => {
									if (
										rorigen.response.geocoding &&
										rorigen.response.geocoding[0]
									) {
										if (
											rorigen.response.geocoding[0].lat &&
											rorigen.response.geocoding[0].long
										) {
											self.consultarDireccion(
												self.envio.destino
											).then((rdestino) => {
												Swal.close();
												if (
													rdestino.response
														.geocoding &&
													rdestino.response
														.geocoding[0]
												) {
													if (
														rdestino.response
															.geocoding[0].lat &&
														rdestino.response
															.geocoding[0].long
													) {
														self.step =
															self.step + 1;
														const geocoding =
															rdestino.response
																.geocoding[0];
														const ogeocoding =
															rorigen.response
																.geocoding[0];
														const {
															lat: olat,
															long: olong,
														} = ogeocoding;
														const { lat, long } =
															geocoding;
														self.calcularCotizacion(
															self.getKilometros(
																lat,
																long,
																olat,
																olong
															)
														);
													} else {
														errorSwal(
															'La calle o el número no son válidos'
														);
													}
												} else {
													errorSwal(
														'El código postal ingresado no es válido'
													);
												}
											});
										} else {
											Swal.close();
											errorSwal(
												'La calle o el número no son válidos'
											);
										}
									} else {
										Swal.close();
										errorSwal(
											'El código postal ingresado no es válido'
										);
									}
								})
								.catch((e) => {
									Swal.close();
									errorSwal(
										'El código postal ingresado no es válido'
									);
								});
						}
					}, 2000);
				},
			}).then((result) => {
				if (result.dismiss === Swal.DismissReason.timer) {
					console.log('Cerrado');
				}
			});
		},
		prevStep() {
			this.step = this.step - 1;
		},
		calcularCotizacion(distancia) {
			const dis = parseFloat(distancia);
			const peso = parseFloat(this.envio.peso);
			const size = {
				0: 0.5,
				1: 0.75,
				2: 1,
				3: 1.25,
			}[this.envio.categoria];
			const date = new Date();
			if (dis <= 10) {
				date.setDate(date.getDate() + 2);
			} else if (dis > 10 && dis < 20) {
				date.setDate(date.getDate() + 3);
			} else {
				date.setDate(date.getDate() + 5);
			}
			this.cotizacion = {
				costo: parseFloat(dis * peso * size * 20).toFixed(2),
				fecha: date,
			};
		},
		realizarEnvio() {},
		getKilometros(lat1, lon1, lat2, lon2) {
			rad = function (x) {
				return (x * Math.PI) / 180;
			};
			const R = 6378.137;
			const dLat = rad(lat2 - lat1);
			const dLong = rad(lon2 - lon1);
			const a =
				Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos(rad(lat1)) *
					Math.cos(rad(lat2)) *
					Math.sin(dLong / 2) *
					Math.sin(dLong / 2);
			const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			const d = R * c;
			return d.toFixed(2);
		},
		consultarDireccion(direccion) {
			return $.get(
				'https://api.copomex.com/query/info_cp_geocoding/' +
					direccion.cp +
					'?' +
					$.param({
						calle: direccion.calle,
						numero: direccion.numero,
						type: 'simplified',
						// token: 'a31db21f-63cc-4344-80d5-f74485aa6c78', // Nuevo token
                        token: 'a57b9385-df06-438b-bb43-678195835885'
					})
			);
		},
		mostrarFecha(fecha) {
			const d = new Date(fecha);
			return (
				d.getDate() +
				' de ' +
				{
					0: 'Enero',
					1: '',
					11: 'Diciembre',
				}[d.getMonth() % 12]
			);
		},
	},
});
