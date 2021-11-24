(function(){

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

    if (params.has('err')) {
		errorSwal(
			{
				1: 'Correo o contraseña incorrectos',
				2: 'Ocurrio un error interno, intentalo de nuevo mas tarde',
			}[params.get('err')]
		);
	}

	

})()

function onCaptcha(token) {
	console.log(token);
}