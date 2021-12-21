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