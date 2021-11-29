(function(){

	window.token = null;
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

    if (params.has('err')) {
		errorSwal(
			{
				1: 'Correo o contraseña incorrectos',
				2: 'Ocurrio un error interno, intentalo de nuevo mas tarde',
				3: 'Captcha inválido',
			}[params.get('err')]
		);
	} else if (params.has('created')) {
		successSwal("Registro completo");
	} else if (params.has('password')) {
		successSwal("Contraseña actualizada");
	}

	

})()

function onCaptcha(token) {
	document.getElementById("token").value = token;
}

function expiredCaptcha() {
	document.getElementById("token").value = "";
}