function errorSwal(message) {
	if (message) {
		Swal.hideLoading()
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
		Swal.hideLoading()
		Swal.fire({
			icon: 'success',
			text: message,
			showCancelButton: false,
			showConfirmButton: false,
			showCloseButton: true,
		});
	}
}

function loadingSwal() {
	Swal.fire({
		didOpen: () => {
			Swal.showLoading();
		},
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
	})
}
