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
				1: 'Dirección',
				2: 'Cotización',
			},
			step: 0,
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
					nombre === '')
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

			if (cp === '07510') {
				errorSwal('Intente con otra dirección');
				return;
			}

			const self = this;
			Swal.fire({
				title: 'Calculando',
				didOpen: () => {
					Swal.showLoading();
					setTimeout(() => {
						Swal.close();
						self.step = self.step + 1;
                        let direccionOrigen = {};
                        if (self.envio.recoleccion === "sucursal") {
                            
                        }

                        self.consultarDireccion(self.envio.origen).then(rorigen => {
                            self.consultarDireccion(self.envio.destino).then(rdestino => {

                            })
                        })
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
		realizarEnvio() {},
		getKilometros(lat1, lon1, lat2, lon2) {
			rad = function (x) {
				return (x * Math.PI) / 180;
			};
			const R = 6378.137; //Radio de la tierra en km
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
			return d.toFixed(3); //Retorna tres decimales
		},
		consultarDireccion(direccion) {
			return $.get(
				'https://api.copomex.com/query/info_cp_geocoding/' + direccion.cp + '?' +
					$.param({
						calle: direccion.calle,
						numero: direccion.numero,
						type: 'simplified',
						token: 'a57b9385-df06-438b-bb43-678195835885',
					})
			);
		},
	},
});
