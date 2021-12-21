new Vue({
	el: '#root',
	data() {
		return {
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
			loadingSwal();
			$.post('./controlador/rastreo.php', {
				id: this.numGuia,
			})
				.then((res) => {
					Swal.close();
					const r = JSON.parse(res);
					console.log(r);
					this.data = r.extra;
				})
				.catch((e) => {
					console.log(e);
				});
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
            return parseInt(this.data.envio.estado)
        }
	},
	mounted() {
		const params = new URLSearchParams(window.location.search);
		if (params.get('guia')) {
			this.numGuia = params.get('guia');
			loadingSwal();
			setTimeout(() => {
				this.getRastreo();
			}, 500);
		}
	},
});
