/*Notification Init */
setTimeout(function(){
	$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
},100);
$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
	animate: {
		enter: 'animated bounceInDown',
		exit: 'animated bounceOutUp'
	},
	type: "dismissible alert-primary",
		delay:5000
});
$('#primary_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "primary",
		allow_dismiss:false
	});
});
$('#warning_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "warning",
		allow_dismiss:false
	});
});
$('#info_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "info",
		allow_dismiss:false
	});
});	
$('#success_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "success",
		allow_dismiss:false
	});
});	
$('#danger_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "danger",
		allow_dismiss:false
	});
});


$('#d_primary_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
	});
});
$('#d_warning_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-warning",
	});
});
$('#d_info_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-info",
	});
});	
$('#d_success_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-success",
	});
});	
$('#d_danger_notification').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-danger",
	});
});


$('#top_right_pos').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
		placement: {
			from: "top",
			align: "right"
		},
	});
});
$('#bottom_right_pos').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
		placement: {
			from: "bottom",
			align: "right"
		},
	});
});
$('#top_left_pos').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
		placement: {
			from: "top",
			align: "left"
		},
	});
});
$('#bottom_left_pos').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
		placement: {
			from: "bottom",
			align: "left"
		},
	});
});
$('#bottom_center_pos').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInUp',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
		placement: {
			from: "bottom",
			align: "center"
		},
	});
});
$('#top_center_pos').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "dismissible alert-primary",
		placement: {
			from: "top",
			align: "center"
		},
	});
});
$('#check_anim_notify').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: "animated " + $("#hk_notify_animate_enter").val(),
			exit: "animated " + $("#hk_notify_animate_exit").val()
		},
		type: "dismissible alert-primary",
		placement: {
			from: "top",
			align: "left"
		},
	});
});
$('#url_notify').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
		$.notify({
			message: "Check out my twitter account by clicking on this notification!",
			url: "https://twitter.com/hencework",
			target: "_self"
		},{
			animate: {
				enter: 'animated bounceInDown',
				exit: 'animated bounceOutUp'
			},
			type: "dismissible alert-primary",
			delay:50000000
		});
});
$('#icon_notify').on('click', function(event) {
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	event.preventDefault();
	$.notify({
		icon: 'ri-award-line mr-5',
		message: "You're not limited to just Bootstrap Font Icons",
		placement: {
			from: "top",
			align: "left"
		},
	},{	type: "dismissible alert-primary",delay:50000000});
});
$('#title_notify').on('click', function(event) {
	event.preventDefault();
	setTimeout(function(){
		$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
	},100);
	$.notify({
		title: '<strong>Heads up!</strong>',
		message: "You're not limited to just Bootstrap Font Icons",
	},{
		type: "dismissible alert-primary",
	});
});
$('#update_notify').on('click', function(event) {
	var notify = $.notify('<strong>Saving</strong> Do not close this page...', {
		type: 'success',
		allow_dismiss: false,
		showProgressbar: true,
	});

	setTimeout(function() {
		notify.update('message', '<strong>Saving</strong> Page Data.');
	}, 1000);

	setTimeout(function() {
		notify.update('message', '<strong>Saving</strong> User Data.');
	}, 2000);

	setTimeout(function() {
		notify.update('message', '<strong>Saving</strong> Profile Data.');
	}, 3000);

	setTimeout(function() {
		notify.update('message', '<strong>Checking</strong> for errors.');
	}, 4000);
});	


$('#primary_notification_inverse').on('click', function(event) {
	event.preventDefault();
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "inv alert-inv-primary",
		allow_dismiss:false,
		delay:50000000
	});
});
$('#warning_notification_inverse').on('click', function(event) {
	event.preventDefault();
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "inv alert-inv-warning",
		allow_dismiss:false
	});
});
$('#info_notification_inverse').on('click', function(event) {
	event.preventDefault();
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "inv alert-inv-info",
		allow_dismiss:false
	});
});	
$('#success_notification_inverse').on('click', function(event) {
	event.preventDefault();
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "inv alert-inv-success",
		allow_dismiss:false
	});
});	
$('#danger_notification_inverse').on('click', function(event) {
	event.preventDefault();
	$.notify("Enter: Bounce In from TopExit: Bounce Up and Out", {
		animate: {
			enter: 'animated bounceInDown',
			exit: 'animated bounceOutUp'
		},
		type: "inv alert-inv-danger",
		allow_dismiss:false
	});
});