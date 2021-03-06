(function () {
	const form = document.getElementById('createForm');
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
		
		if (v(e.nombre) === '') return 'El nombre es obligatorio';
		if (!new RegExp('^(?!.* $)[A-Z][a-z]+$').test(v(e.nombre)) && v(e.nombre) != '') return 'El nombre no puede tener digitos ni caracteres especiales';
		if (v(e.apellido) === '') return 'Los apellidos son obligatorios';
		if (!new RegExp('^(?!.* $)[A-Za-z ]+$').test(v(e.apellido)) && v(e.apellido)!= '') return 'El apellido no puede tener digitos ni caracteres especiales';
		if (!/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.
		test(v(e.email).toLowerCase())) return 'El correo electrónico no es valido';
		if (!new RegExp('^.{8,30}$').test(v(e.password)))
			return 'La contraseña debe contener entre 8 y 30 caracteres';
		if (v(e.confirmEmail) !== v(e.email))
			return 'Confirma tu correo electrónico';
		if (v(e.confirmPassword) !== v(e.password))
			return 'Las contraseñas no coinciden';
		if(v(e.phone) === '') return 'El telefono es obligatorio';
		if (!new RegExp('^[0-9]{10}$').test(v(e.phone)) && v(e.phone)!= '')
			return 'El teléfono debe ser de 10 dígitos sin letras ni caracteres especiales';
		// if (v(e.rfc) !== '' && !new RegExp('^[a-zA-Z0-9]{13}$').test(v(e.rfc)))
		// 	return 'El RFC debe ser de 13 caracteres alfanuméricos';
		return null;
	}

	form.addEventListener('submit', (e) => {
		const err = validate(e.target.elements);
		if (err) {
			e.preventDefault();
			errorSwal(err);
		}
	});

	if (params.has('err')) {
		errorSwal(
			{
				1: 'Ya existe una cuenta con el correo electrónico que intentas registrar',
				2: 'Ocurrio un error interno, intentalo de nuevo mas tarde',
				3: 'Hubo un problema creando tu cuenta, intentalo de nuevo mas tarde',
			}[params.get('err')]
		);
	}
})();
