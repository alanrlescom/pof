new Vue({
	el: '#root',
	data() {
		return { numGuia: '' };
	},
	methods: {
		getRastreo() {
            loadingSwal();
			$.post('./controlador/rastreo.php', {
				id: this.numGuia,
			})
				.then((res) => {
                    Swal.close();
					const r = JSON.stringify(res);
				})
				.catch((e) => {
					console.log(e);
				});
		},
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
