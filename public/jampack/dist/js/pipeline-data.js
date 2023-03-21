/*Pipeline Init*/
/* Custom Dragula JS */
dragula([document.getElementById("i1"), document.getElementById("i2"), document.getElementById("i3"), document.getElementById("i4"), document.getElementById("i5"), document.getElementById("i6")]);
dragula([document.getElementById("tasklist_wrap")], {
	moves: function (el, container, handle) {
		return handle.classList.contains('spipeline-handle');
	}
});
/* Single Date*/
$('input[name="single-date-pick"]').daterangepicker({
	singleDatePicker: true,
	startDate: moment().startOf('hour'),
	showDropdowns: true,
	minYear: 1901,
	"cancelClass": "btn-secondary",
	locale: {
	  format: 'YYYY-MM-DD'
	}
});
/*Individual Add Task*/
var $closestTarget;
$(document).on("click", ".btn-add-newtask", function (e) {
	$closestTarget = $(this).closest('.spipeline-list').find(".tasklist-cards-wrap");
	$('.add-new-task input.form-control.task-name').val("");
	$('.add-new-task input.form-control.est-cost').val("");
});
$(document).on("click", ".btn-add-task", function (e) {
	e.preventDefault();
	var taskName, htmlBlock, estcost;
	if ($('.add-new-task input.form-control.task-name').val()) {
		taskName = $('.add-new-task input.task-name').val();
	} else {
		taskName = "Dummy Task";
	}
	if ($('.add-new-task input.form-control.est-cost').val()) {
		estcost = $('.add-new-task input.est-cost').val();
	} else {
		estcost = "1234";
	}
	htmlBlock = `<div class="card card-border spipeline-card">
					<div class="card-body">
						<div class="card-action-wrap">
							<a class="btn btn-xs btn-icon btn-rounded btn-primary dropdown-toggle no-caret" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></span></a>
							<div class="dropdown-menu dropdown-menu-icon-text dropdown-menu-end spipeline-dropdown">
								<h6 class="dropdown-header text-muted">Scheduled activity</h6>
								<a class="dropdown-item" href="#">
									<div class="d-flex align-items-center">
										<div class="me-3 position-relative text-disabled">
											<i class="ri-checkbox-blank-circle-line"></i>
										</div>
										<div class="mw-175p">
											<div class="h6 mb-0 text-truncate">Call arranged with James</div>
											<p class="dropdown-item-text text-truncate text-danger">Yesterday 4:30 pm</p>
										</div>
										<div class="avatar avatar-icon avatar-xxs avatar-soft-danger avatar-rounded ms-3">
											<span class="initial-wrap">
												<span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></span>
											</span>
										</div>
									</div>
								</a>
								<a class="dropdown-item" href="#">
									<div class="d-flex align-items-center">
										<div class="me-3 position-relative text-disabled">
											<i class="ri-checkbox-blank-circle-line"></i>
										</div>
										<div class="mw-175p">
											<div class="h6 mb-0 text-truncate">Call arranged with Locus</div>
											<p class="dropdown-item-text text-truncate">21 Jan 20, 12:40 pm</p>
										</div>
										<div class="avatar avatar-icon avatar-xxs avatar-light avatar-rounded ms-3">
											<span class="initial-wrap">
												<span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></span>
											</span>
										</div>
									</div>
								</a>
								<a class="dropdown-item" href="#">
									<div class="d-flex align-items-center">
										<div class="me-3 position-relative text-disabled">
											<i class="ri-checkbox-blank-circle-line"></i>
										</div>
										<div class="mw-175p">
											<div class="h6 mb-0 text-truncate">Demo arranged with Locus strong</div>
											<p class="dropdown-item-text text-truncate">9 Nov 20, 9:40 am</p>
										</div>
										<div class="avatar avatar-icon avatar-xxs avatar-soft-primary avatar-rounded ms-3">
											<span class="initial-wrap">
												<span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></span>
											</span>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<div class="media">
							<div class="media-head">
								<div class="avatar avatar-logo avatar-rounded">
									<span class="initial-wrap">
										<img src="dist/img/symbol-avatar-4.png" alt="logo">
									</span>
								</div>
							</div>
							<div class="media-body">
								<div class="brand-name">${taskName}</div>
								<div class="price-estimation">$${estcost}</div>
								<div class="brand-cat">Dashboard Template</div>
								<div class="media align-items-center">
									<div class="media-head">
										<div class="avatar avatar-xs avatar-rounded d-4 d-flex">
											<img src="dist/img/avatar8.jpg" alt="user" class="avatar-img">
										</div>
									</div>
									<div class="media-body">
										<p>24 days</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>`;
	$(htmlBlock).appendTo($closestTarget);
	$(this).parents().find('.modal').modal("hide");
});

/*Edit List*/
var $tasklistHead;
$(document).on("click", ".edit-tasklist", function (e) {
	e.preventDefault();
	$('.edit-tasklist-modal  input').val($(this).closest('.spipeline-handle').find('h6').text());
	$tasklistHead = $(this).parent().parent().parent().find('h6');
});
$(document).on("click", ".btn-edit-tasklist", function (e) {
	e.preventDefault();
	$tasklistHead.text($('.edit-tasklist-modal input').val());
	$(this).parents().find('.modal').modal("hide");
});

/*Delete List*/
$(document).on("click", ".delete-tasklist", function (e) {
	e.preventDefault();
	$(this).closest('.spipeline-list').remove();
});

/*Clear List*/
$(document).on("click", ".clear-tasklist", function (e) {
	e.preventDefault();
	$(this).closest('.spipeline-list').find('.spipeline-card').remove();
});

/*Individual List*/
$(document).on("click", ".btn-add-newlist", function (e) {
	$('.add-tasklist-modal input.form-control').val("");
});
$(document).on("click", ".btn-add-tasklist", function (e) {
	e.preventDefault();
	var taskListName, htmlBlock;
	if ($('.add-tasklist-modal input.form-control').val())
		taskListName = $('.add-tasklist-modal input.form-control').val();
	else
		taskListName = "All Modules";
	htmlBlock = '<div class="card card-simple card-flush spipeline-list"><div class="card-header card-header-action"><div class="spipeline-handle"><h6 class="hd-uppercase mb-0">' + taskListName + '</h6><div class="card-action-wrap"><a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover dropdown-toggle no-caret" href="#" data-bs-toggle="dropdown"><span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></span></span></a><div role="menu" class="dropdown-menu dropdown-menu-end"><a class="dropdown-item edit-tasklist" href="#" data-bs-toggle="modal" data-bs-target="#edit_task_list">Edit</a><a class="dropdown-item delete-tasklist" href="#">Delete</a><a class="dropdown-item clear-tasklist" href="#">Clear All</a></div></div></div><div><span><span class="overall-estimation">$5,268</span><span class="spipeline-dot-sep">●</span><span class="lead-count">7 Leads</span></span></div><button class="btn btn-light btn-block btn-wth-icon text-primary btn-add-newtask" data-bs-toggle="modal" data-bs-target="#add_new_deal"><span><span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span></span><span class="btn-text">Add Card</span></span></button></div><div class="card-body"><div id="i4" class="tasklist-cards-wrap"></div></div></div>';
	$(htmlBlock).insertBefore($('.create-new-list'));
	$(this).parents().find('.modal').modal("hide");
});