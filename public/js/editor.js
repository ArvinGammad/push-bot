$(document).on('click','#btn-save-article',function(e){
	// 
	Swal.fire({
		title: 'Processing your request.',
		showCancelButton: false,
		showConfirmButton: false,
		didOpen: () => {
    		Swal.showLoading()
    	},
    	allowOutsideClick: () => !Swal.isLoading()
	})
})