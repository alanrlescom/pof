function calcKm({ lat: lat1, lon: lon1 }, { lat: lat2, lon: lon2 }) {
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
}

function validaDireccion(dir, mess) {
	const { cp, colonia, calle, numero, estado, nombre } = dir;
	const f =
		cp !== '' &&
		colonia !== '' &&
		numero !== '' &&
		calle !== '' &&
		estado !== '' &&
		nombre !== '';
	if (!f) {
		errorSwal(mess);
	}
	return f;
}

function validaPeso(peso) {
	if (!peso) {
		errorSwal('El peso no puede ser menor o igual a cero.');
		return false;
	}
	if (peso <= 0) {
		errorSwal('El peso no puede ser menor o igual a cero.');
		return false;
	}
	if (peso > 50) {
		errorSwal('No se permiten envios con peso mayor a 50Kg.');
		return false;
	}
	return true;
}

function sepomexRequest(url, body) {
	return new Promise((solve, reject) => {
		$.ajax('https://sepomex.razektheone.com/' + url + '?' + $.param(body), {
			headers: {
				Apikey: 'b93424ad68356bf9aed75e0d4f42d3129817c3e0',
			},
			success: function (d) {
				const data = JSON.parse(d);
				if (data.error) {
					reject();
				} else {
					solve(data);
				}
			},
			error: function (e, status) {
				console.log(e, status);
				reject();
			},
		});
	});
}

function geocodingRequest(dir) {
	const { calle, numero, colonia, estado, cp } = dir;
	return $.get(
		'http://api.positionstack.com/v1/forward?' +
			$.param({
				access_key: '7265d75e9680ba837540547495b929f2',
				country: 'MX',
				query: `${calle} ${numero}, ${colonia}, ${cp} ${estado}`,
			})
	).then((d) => {
		if (d.data.length === 0) {
			throw new Error('No hay informacion');
		}
		return d.data[0];
	});
}

const stripe = Stripe(
	'pk_test_51K74NuJ4An9dIGcQpyb7pUfF6IKW0Llc4SXI1qYuMSAaYksgipYrhv0LNUzlNYlViQPcJOALFHCWyjxD0Ig2EeoD00biXQXBw1',
	{
		locale: 'es',
	}
);

const vue = new Vue({
	el: '#root',
	data() {
		return {
			subtitle: {
				0: '',
				1: '',
				2: '',
			},
			title: {
				0: 'Cotizar envio',
				1: 'Entrega estimada:',
				2: 'Pago:',
			},
			step: 2,
			estados: [],
			sucursales: [
				{
					value: 0,
					label: 'ESCOM',
					data: { lat: 19.505, lon: -99.14666667 },
				},
			],
			tiposRecoleccion: [
				{
					value: 2,
					label: 'Recolectar en sucursal, entregar a domicilio',
				},
				{
					value: 0,
					label: 'Recolectar a domicilio, entregar a domicilio',
				},
				{
					value: 1,
					label: 'Recolectar a domicilio, entregar en sucursal',
				},
				{
					value: 3,
					label: 'Recolectar en surcursal, entregar en sucursal',
				},
			],
			envio: {
				categoria: 0,
				peso: 0,
				recoleccion: 2,
				origen: {
					sucursal: 0,
					cp: '',
					colonia: '',
					calle: '',
					numero: '',
					estado: 'CIUDAD DE MEXICO',
					municipio: '',
					nombre: '',
					email: '',
					telefono: '',
				},
				destino: {
					sucursal: 0,
					cp: '',
					colonia: '',
					calle: '',
					numero: '',
					estado: 'CIUDAD DE MEXICO',
					municipio: '',
					nombre: '',
					email: '',
					telefono: '',
				},
			},
			cotizacion: {
				costo: '0.0',
				fecha: new Date(),
				distancia: '0',
				pesoVolumetrico: 0,
			},
			stripeElements: null,
			paymentElement: null,
		};
	},
	methods: {
		prevStep() {
			this.step = this.step - 1;
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
		async cotizar() {
			const { peso } = this.envio;
			const { recoleccion, origen, destino } = this.envio;
			const { cp: ocp, nombre: onombre } = origen;
			const { cp, nombre } = destino;

			if (!validaPeso(peso)) return;

			if (nombre === '') {
				errorSwal(
					'Complete todos los campos de los datos de destino y vuelva a intentarlo por favor'
				);
				return;
			}

			if (onombre === '') {
				errorSwal(
					'Complete todos los campos de los datos del remitente y vuelva a intentarlo por favor'
				);
				return;
			}

			if (
				[0, 1].includes(recoleccion) && // Si la recoleccion es a domicilio
				!validaDireccion(
					origen,
					'Complete todos los campos de los datos del remitente y vuelva a intentarlo por favor'
				)
			)
				return;

			if (
				[0, 2].includes(recoleccion) && // Si la entrega es a domicilio
				!validaDireccion(
					destino,
					'Complete todos los campos de los datos de destino y vuelva a intentarlo por favor'
				)
			)
				return;

			// Esto es para probar la disponibilidad
			// dependiendo del codigo postal
			if (cp === '07511' || ocp === '07511') {
				errorSwal('Intente con otra dirección');
				return;
			}

			const self = this;

			loadingSwal();
			new Promise((solve, reject) => {
				if ([0, 1].includes(recoleccion)) {
					geocodingRequest(origen)
						.then((d) => {
							solve({ lat: d.latitude, lon: d.longitude });
						})
						.catch((e) => reject());
				} else {
					const d = self.sucursales.find(
						(v) => v.value === origen.sucursal
					).data;
					solve({ lat: d.lat, lon: d.lon });
				}
			})
				.then((infoOrigen) => {
					new Promise((solve, reject) => {
						if ([0, 2].includes(recoleccion)) {
							geocodingRequest(destino)
								.then((d) => {
									solve({
										lat: d.latitude,
										lon: d.longitude,
									});
								})
								.catch((e) => reject());
						} else {
							const d = self.sucursales.find(
								(v) => v.value === destino.sucursal
							).data;
							solve({ lat: d.lat, lon: d.lon });
						}
					})
						.then((infoDestino) => {
							self.calcularCotizacion(
								calcKm(infoOrigen, infoDestino)
							);
							self.step = self.step + 1;
							Swal.close();
						})
						.catch((err) => {
							errorSwal('La calle o el número no son válidos');
						});
				})
				.catch((err) => {
					errorSwal('La calle o el número no son válidos');
				});
		},
		calcularCotizacion(distancia) {
			const dis = parseFloat(distancia);
			const peso = parseFloat(this.envio.peso);
			const size = {
				0: [10, 10, 10],
				1: new Array(3).fill(15),
				2: new Array(3).fill(25),
				3: new Array(3).fill(40),
			}[this.envio.categoria];
			const date = new Date();

			const pesoVolumetrico = ([w, h, d]) => {
				return (w * h * d) / 5000;
			};

			const precioPorKilometro = (dis) => {
				return Math.ceil(dis / 10) * 100;
			};

			if (dis <= 10) {
				date.setDate(date.getDate() + 2);
			} else if (dis > 10 && dis < 20) {
				date.setDate(date.getDate() + 3);
			} else {
				date.setDate(date.getDate() + 5);
			}

			this.cotizacion = {
				costo: parseFloat(
					precioPorKilometro(dis) * (pesoVolumetrico(size) / 100)
				).toFixed(2),
				fecha: date,
				distancia: distancia,
				pesoVolumetrico: pesoVolumetrico(size),
			};
		},
		realizarEnvio(hasSession) {
			const self = this;
			loadingSwal();
			if (hasSession === 1) {
				this.iniciaPago()
					.then((_) => {
						Swal.close();
						self.step = self.step + 1;
					})
					.catch((e) => {
						console.log(e);
					});
			} else {
				localStorage.setItem(
					'POF_ENVIO_INFO',
					JSON.stringify({
						envio: this.envio,
						cotizacion: this.cotizacion,
					})
				);
				window.location.href = './login.php?save=1';
			}
		},
		guardarEnvio(e) {
			e.preventDefault();
			loadingSwal();
			$.post("./controlador/guardarEnvio.php", {
				envio: JSON.stringify(this.envio),
				cotizacion: JSON.stringify(this.cotizacion),
			}).then(rguardar => {
				if (rguardar.status === 200) {
					stripe.confirmPayment({
						//`Elements` instance that was used to create the Payment Element
						elements: this.stripeElements,
						confirmParams: {
							return_url: 'https://216.238.74.227/pof/envioRealizado.php',
						},
					}).then(rstripe => {
						if (rstripe.error) {
							$.post("./controlador/eliminarEnvio.php", {
								id: rguardar.extras.id,
							}).then(r => {
								Swal.close();
								if (r.status === 200) {
									// Mostrar error de stripe
								} else {
									errorSwal(r.message);
								}
							}).catch(err => {
								Swal.close();
								errorSwal("Ocurrio un error desconocido");
							})
						}
					})
				} else {
					Swal.close();
					errorSwal(rguardar.message);
				}
			}).catch(err => {
				Swal.close();
				errorSwal("Ocurrio un error desconocido");
			})
		},
		consultarCodigoPostal(obj) {
			sepomexRequest('codigo_postal', { cp: obj.cp })
				.then((d) => {
					const { estado, municipio, colonias } = d.codigo_postal;
					obj.estado = estado;
					obj.municipio = municipio;
					obj.colonias = colonias.map((v) => v.colonia);
					if (obj.colonias.length > 0) {
						obj.colonia = obj.colonias[0];
					}
				})
				.catch((e) => {
					errorSwal('El código postal ingresado no es válido');
				});
		},
		obtenerEstados() {
			const self = this;
			sepomexRequest('estados', {})
				.then((d) => {
					self.estados = d.estados.map((v) => v.ESTADO);
				})
				.catch(console.log);
		},
		iniciaPago() {
			return $.post('./controlador/clientSecret.php', {
				amount: 100,
			}).then((r) => {
				self.stripeElements = stripe.elements({
					clientSecret: r.clientSecret,
					appearance: {
						theme: 'flat',
					},
				});

				self.paymentElement = stripeElements.create('payment', {
					wallets: {
						googlePay: 'never',
					},
					fields: {
						billingDetails: {
							address: 'never',
						},
					},
				});
				paymentElement.mount('#payment-element');
			});
		},
		cancelar() {
			window.location.href = './index.php';
		},
	},
	mounted() {
		this.obtenerEstados();
		const params = new URLSearchParams(window.location.search);

		if (localStorage.getItem('POF_ENVIO_INFO')) {
			if (params.has('save')) {
				const d = JSON.parse(localStorage.getItem('POF_ENVIO_INFO'));
				this.envio = d.envio;
				this.cotizacion = d.cotizacion;
				this.step = 1;
			} else {
				localStorage.removeItem('POF_ENVIO_INFO');
			}
		}
	},
});
