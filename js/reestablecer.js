(function () {
	const form = document.getElementById('newPassword');
	const params = new URLSearchParams(window.location.search);

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

	function validate(e) {
		const v = (elem) => elem.value;
		if (!new RegExp('^.{8,30}$').test(v(e.password)))
			return 'La contraseña debe contener entre 8 y 30 caracteres';
		if (v(e.confirmPassword) !== v(e.password))
			return 'Las contraseñas no coinciden';
		return null;
	}

	if (form) {
		form.addEventListener('submit', (e) => {
			const err = validate(e.target.elements);
			if (err) {
				e.preventDefault();
				errorSwal(err);
			}
		});
	}

	if (params.has('err')) {
		errorSwal(
			{
				1: 'No se encontro una cuenta registrada con este correo',
				2: 'Ocurrio un error con la base de datos',
				3: 'No es válido el enlace para reestablecer, verifica si no hay un correo mas reciente',
				4: ''
			}[params.get('err')]
		);
	}
})();
