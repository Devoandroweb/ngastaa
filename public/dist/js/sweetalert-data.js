/*Sweet Alert2*/
$(document).on("click",'#sweetalert_1',function (e) {
	Swal.fire({
		html:
		'<div class="d-flex align-items-center"><i class="ri-calendar-check-line me-2 fs-1 text-success"></i><h4 class="mb-0">You created a new event</h4></div>',
		customClass: {
			content: 'p-0',
			actions: 'justify-content-start',
		},
		width: 400,
		showConfirmButton:false,
		buttonsStyling: false
	 })
});
$(document).on("click",'#sweetalert_2',function (e) {
	Swal.fire({
		html:
		'<div class="d-flex align-items-center"><i class="ri-checkbox-line me-2 fs-3 text-success"></i><h5 class="text-success mb-0">Your task has been added!</h5></div><p class="mt-2">Check your email for the confirmation. Dont forget to set the reminder in your task list</p>',
		customClass: {
			content: 'p-0 text-start',
			confirmButton: 'btn btn-primary',
			actions: 'justify-content-start',
		},
		buttonsStyling: false,
	})
});
$(document).on("click",'#sweetalert_3',function (e) {
	Swal.fire({
		html:
		`<div class="avatar avatar-icon avatar-soft-danger mb-3"><span class="initial-wrap"><i class="ri-close-circle-fill"></i></span></div>
		<div>
			<h4 class="text-danger">Oops! API validation failed</h4>
			<p class=" mt-2">Please add a valid format for API and try again.</p>
		</div>`,
		customClass: {
			container:'swal2-has-footer',
			content: 'p-0',
			confirmButton: 'btn btn-primary',
		},
		buttonsStyling: false,
		footer: '<a href="#">Why do I have this issue?</a>'
		
	 })
});
$(document).on("click",'#sweetalert_5',function (e) {
	Swal.fire({
		title: '<span>Permanently Delete: <i class="ri-folder-5-fill text-warning px-2"></i>Roboto cheesecake</span>',
		html:
		'<p>You are about to permanently delete <a href="#">roboto-cheesecake</a> and all its content .You will not be able to recover this folder or its content from recycle bin. <strong>This operation can not be undone.</strong></p><form class="mt-3"><div class="form-group"><label class="form-label" for="inputText">Type "DELETE" to confirm</label><input type="text" id="inputText" class="form-control" aria-describedby="passwordHelpBlock"></div></form>',
		customClass: {
			container:'swal2-has-header',
			header: 'align-items-start',
			content: 'p-0 text-start',
			confirmButton: 'btn btn-danger',
			actions: 'justify-content-end mt-3',
			cancelButton: 'btn btn-secondary me-2',
		},
		showCancelButton: true,
		reverseButtons: true,
		confirmButtonText: 'Yes, delete it!',
		buttonsStyling: false,
	}).then((result) => {
	  if (result.value) {
		Swal.fire({
			html:
			'<div class="d-flex align-items-center"><i class="ri-delete-bin-5-fill me-2 fs-3 text-danger"></i><h5 class="text-danger">Your file has been deleted!</h5></div>',
			customClass: {
				content: 'p-0 text-start',
				confirmButton: 'btn btn-primary',
				actions: 'justify-content-start',
			},
			buttonsStyling: false,
		})
	  }
	})
});
$(document).on("click",'#sweetalert_8',function (e) {
	Swal.fire({
		html:
		'<div class="mb-3"><i class="ri-delete-bin-6-line fs-5 text-danger"></i></div><h5 class="text-danger">Delete Note ?</h5><p>Deleting a note will permanently remove from your library.</p>',
		customClass: {
			confirmButton: 'btn btn-outline-secondary text-danger',
			cancelButton: 'btn btn-outline-secondary text-grey',
			container:'swal2-has-bg'
		},
		showCancelButton: true,
		buttonsStyling: false,
		confirmButtonText: 'Yes, Delete Note',
		cancelButtonText: 'No, Keep Note',
		reverseButtons: true,
	}).then((result) => {
	  if (result.value) {
		Swal.fire({
			html:
			'<div class="d-flex align-items-center"><i class="ri-delete-bin-5-fill me-2 fs-3 text-danger"></i><h5 class="text-danger mb-0">Your file has been deleted!</h5></div>',
			customClass: {
				content: 'p-0 text-start',
				confirmButton: 'btn btn-primary',
				actions: 'justify-content-start',
			},
			buttonsStyling: false,
		})
	  }
	})
});
$(document).on("click",'#sweetalert_10',function (e) {
	Swal.fire({
	  title: 'Sweet!',
	  text: 'Modal with a custom image.',
	  imageUrl: 'dist/img/avatar1.jpg',
	  imageWidth: 'auto',
	  imageHeight: 150,
	  imageAlt: 'Custom image',
		customClass: {
			confirmButton: 'btn btn-primary',
		},
		buttonsStyling: false,
	})
});
$(document).on("click",'#sweetalert_7',function (e) {
	Swal.fire({
		html:
		`<div class="d-flex align-items-center">
			<div class="avatar avatar-icon avatar-soft-danger me-3"><span class="initial-wrap"><i class="ri-close-circle-fill"></i></span></div>
			<div>
				<h4 class="text-danger">Oops! API validation failed</h4>
				<p>Please add a valid format for API and try again.</p>
			</div>
		</div>`,
		customClass: {
			confirmButton: 'btn btn-outline-secondary text-danger',
			cancelButton: 'btn btn-outline-secondary text-grey',
			container:'swal2-has-bg',
			content: 'bg-transparent border-bottom text-start',
		},
		showClass: {
		popup: 'animated fadeInDown faster'
		},
		hideClass: {
		popup: 'animated fadeOutUp faster'
		},
		showCancelButton: true,
		buttonsStyling: false,
		showCloseButton:true,
		confirmButtonText: 'TRY AGAIN',
		cancelButtonText: 'CLOSE',
		reverseButtons: true,
	}).then((result) => {
	  if (result.value) {
		Swal.fire({
			html:
			'<div class="d-flex align-items-center"><i class="ri-delete-bin-5-fill me-2 fs-3 text-danger"></i><h5 class="text-danger">Your file has been deleted!</h5></div>',
			customClass: {
				content: 'p-0 text-start',
				confirmButton: 'btn btn-primary',
				actions: 'justify-content-start',
			},
			buttonsStyling: false,
		})
	  }
	})
});
$(document).on("click",'#sweetalert_14',function (e) {
	Swal.fire({
		html:
		`<div class="avatar avatar-icon avatar-dark mb-3">
			<span class="initial-wrap ">
			<i class="ri-github-fill"></i>
			</span>
		</div>
		<h5 class="mb-0">Sumit you github user name</h5>`,
		input: 'text',
		inputAttributes: {
		autocapitalize: 'off'
		},
		customClass: {
			content: 'p-0',
			confirmButton: 'btn btn-primary me-2',
			cancelButton: 'btn btn-secondary',
			input: 'form-control'
		},
		buttonsStyling: false,
		showCancelButton: true,
		confirmButtonText: 'Look up',
		showLoaderOnConfirm: true,
		preConfirm: (login) => {
		return fetch(`//api.github.com/users/${login}`)
		  .then(response => {
			if (!response.ok) {
			  throw new Error(response.statusText)
			}
			return response.json()
		  })
		  .catch(error => {
			Swal.showValidationMessage(
			  `Request failed: ${error}`
			)
		  })
		},
		allowOutsideClick: () => !Swal.isLoading()
		}).then((result) => {
		if (result.value) {
		Swal.fire({
		  title: `${result.value.login}'s avatar`,
		  imageUrl: result.value.avatar_url
		})
		}
		})
});
$(document).on("click",'#sweetalert_15',function (e) {
	Swal.mixin({
	  input: 'text',
	  confirmButtonText: 'Next &rarr;',
	  showCancelButton: true,
	  buttonsStyling: false,
	  customClass: {
		content: 'p-0',
		confirmButton: 'btn btn-primary me-2',
		cancelButton: 'btn btn-secondary',
		input: 'form-control'
	},
	  progressSteps: ['01', '02', '03']
	}).queue([
	  {
		title: '<h5>How did you know about Jampack ?<h5>',
		text: 'Tell us about the source you came to know us about in single line'
	  },
	  'Question 2',
	  'Question 3'
	]).then((result) => {
	  if (result.value) {
		Swal.fire({
		  title: '<h5 class="mb-2">All done!</h5>',
		  html:
			'Your answers: <pre><code>' +
			  JSON.stringify(result.value) +
			'</code></pre><button class="btn btn-primary bg-twitter btn-wth-icon icon-wthot-bg me-2 mt-25"><span class="icon-label"><i class="fab fa-twitter"></i> </span><span class="btn-text">twitter</span></button><button class="btn btn-primary bg-facebook btn-wth-icon icon-wthot-bg mt-25"><span class="icon-label"><i class="fab fa-facebook"></i> </span><span class="btn-text">facebook</span></button>',
			buttonsStyling: false,
			customClass: {
				content: 'p-0',
				confirmButton: 'btn btn-primary d-none',
			},
		})
	  }
	})
});
$(document).on("click",'#sweetalert_6',function (e) {
	Swal.fire({
		position: 'top-end',
		timer: 15000000,
		html:
		'<div class="d-flex align-items-center"><h5 class="mb-0">Please login to continue</h5></div>',
		customClass: {
			content: 'p-0 text-start',
			container:'swal2-has-footer',
			footer: 'justify-content-start'
		},
		showConfirmButton: false,
		footer: '<a href="#" class="btn btn-primary">Log In</a>'
	})
});
$(document).on("click",'#sweetalert_12',function (e) {
	let timerInterval
	Swal.fire({
	  title: 'Auto close alert!',
	  html: 'I will close in <b></b> milliseconds.',
	  timer: 2000,
	  timerProgressBar: true,
	  onBeforeOpen: () => {
		Swal.showLoading()
		timerInterval = setInterval(() => {
		  const content = Swal.getContent()
		  if (content) {
			const b = content.querySelector('b')
			if (b) {
			  b.textContent = Swal.getTimerLeft()
			}
		  }
		}, 100)
	  },
	  onClose: () => {
		clearInterval(timerInterval)
	  }
	}).then((result) => {
	  /* Read more about handling dismissals below */
	  if (result.dismiss === Swal.DismissReason.timer) {
		console.log('I was closed by the timer')
	  }
	})
});
$(document).on("click",'#sweetalert_13',function (e) {
	Swal.fire({
	  title: 'هل تريد الاستمرار؟',
	  confirmButtonText: 'نعم',
	  cancelButtonText: 'لا',
	  showCancelButton: true,
	  showCloseButton: true,
	  customClass: {
			content: 'p-0',
			confirmButton: 'btn btn-primary me-2',
			cancelButton: 'btn btn-secondary',
			container: 'swal2-rtl'
		},
		buttonsStyling: false,
		showCancelButton: true,
	})
});