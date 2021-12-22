new Vue({
	el: '#root',
	data() {
		return {
			auxNumGuia: '',
			numGuia: '',
			estados: {
				0: 'Envio solicitado',
				1: 'En recolección',
				2: 'Recolectado',
				3: 'En camino',
				4: 'En sucursal',
				6: 'Entregado',
			},
			data: null,
		};
	},
	methods: {
		getRastreo() {
			this.numGuia = this.auxNumGuia;
			if (this.numGuia === "") {
				errorSwal(
					"Campos obligatorios, complete todos los campos por favor."
				)
			}else if (!new RegExp('^[0-9]{1,11}$').test(this.numGuia)) {
				errorSwal(
					'El número de guía ingresado no es válido. Ingrese un número de guía que tenga entre 1 y 11 dígitos.'
				);
			} else {
				loadingSwal();
				$.post('./controlador/rastreo.php', {
					id: this.numGuia,
				})
					.then((res) => {
						Swal.close();
						const r = JSON.parse(res);
						if (r.status === 200) {
							this.data = r.extra;
						} else {
							errorSwal(
								'No existe un envio con este numero de guia'
							);
							this.data = null;
						}
					})
					.catch((e) => {
						console.log(e);
					});
			}
		},
	},
	computed: {
		fechaLlegada() {
			const d = new Date(this.data.envio.fecha_llegada);
			const hoy = new Date();
			if (d.getDate() === hoy.getDate()) {
				return 'hoy';
			}
			return 'el ' + d.getDate();
		},
		fechaCreacion() {
			const d = new Date(this.data.envio.creacion);
			const hoy = new Date();
			if (d.getDate() === hoy.getDate()) {
				return 'hoy';
			}
			return 'el ' + d.getDate();
		},
		fechaEntrega() {
			const d = new Date(this.data.envio.actualizacion);
			const hoy = new Date();

			if (d.getDate() === hoy.getDate()) {
				return 'hoy';
			}
			return 'el ' + d.getDate();
		},
		horaEntrega() {
			return new Date(this.data.envio.actualizacion).toLocaleTimeString();
		},
		estado() {
			return parseInt(this.data.envio.estado);
		},
	},
	mounted() {
		const params = new URLSearchParams(window.location.search);
		if (params.get('guia')) {
			this.auxNumGuia = params.get('guia');
			loadingSwal();
			this.getRastreo();
		}
	},
});
