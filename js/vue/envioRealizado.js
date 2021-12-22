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
            const self = this;
			setTimeout(() => {
                $.post('./controlador/rastreo.php', {
                    id: this.numGuia,
                })
                    .then((res) => {
                        Swal.close();
                        const r = JSON.parse(res);
                        self.data = r.extra;
                        console.log(r.extra)
                        self.enviarCorreo();
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }, 500)
		},
        enviarCorreo() {
            /*
            $.post(
                './controlador/enviarCorreoSeguimiento.php',
                {
                    origen: JSON.stringify(this.data.remitente),
                    destino: JSON.stringify(this.data.destinatario),
                    id: this.numGuia,
                }
            )
                .then(console.log)
                .catch(console.log);
                */
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
        },
        origen() {
            const { origen } = this.data
            const { calle, numero, colonia, municipio, cp, estado } = origen
            return calle + " " + numero + ", " + colonia + " " + municipio + ", " + estado +  " " + cp
        },
        destino() {
            const { destino } = this.data
            const { calle, numero, colonia, municipio, cp, estado } = destino
            return calle + " " + numero + ", " + colonia + " " + municipio + ", " + estado +  " " + cp
        },
	},
	mounted() {
		const params = new URLSearchParams(window.location.search);
		if (params.get('guia')) {
			this.numGuia = params.get('guia');
			loadingSwal();
			this.getRastreo();
		}
	},
});
