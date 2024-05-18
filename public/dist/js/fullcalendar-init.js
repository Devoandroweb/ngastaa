/*Full Calendar Init*/
//Small Calendar
$('input[name="calendar"]').daterangepicker({
	singleDatePicker: true,
	showDropdowns: false,
	minYear: 1901,
	"cancelClass": "btn-secondary",
	autoApply :true,
	parentEl: "#inline_calendar",
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
$('input[name="calendar"]').trigger("click");


var curYear = moment().format('YYYY'), 
curMonth = moment().format('MM');

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar'),
 calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    initialDate: curYear+'-'+curMonth+'-07',
    headerToolbar: {
      left: 'prev,next today',
     center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
	themeSystem: 'bootstrap',
	height: 'parent',
	droppable: true,	
	editable: true,
	events: [
      {
		backgroundColor: '#FFC400',
		borderColor: '#FFC400',
        title: '9:30 AM - 8:00 PM Awwards Conference',
		start: curYear+'-'+curMonth+'-04',
		end: curYear+'-'+curMonth+'-06',
	  },
      {
		backgroundColor: '#da82f8',
		borderColor: '#da82f8',
        title: 'Jampack Team Meet',
        start: curYear+'-'+curMonth+'-13',
        end: curYear+'-'+curMonth+'-15'
      },
      {
		backgroundColor: '#da82f8',
		borderColor: '#da82f8',
        title: 'Project meeting with delegates',
        start: curYear+'-'+curMonth+'-19'
      },
      {
		backgroundColor: '#298DFF',
		borderColor: '#298DFF',
        title: 'Conference',
        start: curYear+'-'+curMonth+'-11',
        end: curYear+'-'+curMonth+'-13'
      },
      {
		title: 'Call back to Morgan Freeman',
        start: curYear+'-'+curMonth+'-27T10:30:00',
      },
      {
		title: 'Grocery Day',
        start: curYear+'-'+curMonth+'-27T12:00:00'
      },
      {
		title: 'Follow-up call with client',
        start: curYear+'-'+curMonth+'-7T14:30:00'
      },
      {
		title: 'Follow-up call with client',
        start: curYear+'-'+curMonth+'-07T07:00:00',
	  },
	  {
		title: 'Grocery Day',
        start: curYear+'-'+curMonth+'-02T07:00:00',
	  },
      {
		backgroundColor: '#298DFF',
		borderColor: '#298DFF',
        title: '<i class="ri-plane-fill"></i><span>2:35 PM  Flight to Indonesia</span>',
        url: 'http://google.com/',
		start: curYear+'-'+curMonth+'-13',
		extendedProps:{
			toHtml: 'convert'
		}
	  },
	  {
		backgroundColor: '#007D88',
		borderColor: '#007D88',
        title: "<i class='ri-cake-line'></i><span>Boss's Birthday</span>",
        start: curYear+'-'+curMonth+'-29',
		extendedProps:{
			toHtml: 'convert'
		}
	  }
    ],
	eventContent: function(arg) {
	  if (arg.event.extendedProps.toHtml) {
			return { html: arg.event.title }
	  } 
	},
	eventClick: function(info) {
		targetEvent = info.event;
	}
  });
  calendar.render();
	var targetDrawer = '.hk-drawer.calendar-drawer',
	targetEvent;
	$(document).on("click",".calendarapp-wrap .fc-daygrid-event",function (e) {
		$(targetDrawer).css({"border": "none", "box-shadow": "0 8px 10px rgba(0, 0, 0, 0.1)"}).addClass('drawer-toggle');
		$('.calendar-drawer').find('.event-name').text($(this).text());
		return false;
	});
	/*Event Delete*/
	$(document).on("click",'#del_event',function (e) {
		$(this).closest('.hk-drawer').removeClass('drawer-toggle');
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
			targetEvent.remove();
			Swal.fire({
				html:
				'<div class="d-flex align-items-center"><i class="ri-delete-bin-5-fill me-2 fs-3 text-danger"></i><h5 class="text-danger mb-0">Event has been deleted!</h5></div>',
				timer: 2000,
				customClass: {
					content: 'p-0 text-left',
					actions: 'justify-content-start',
				},
				showConfirmButton:false,
				buttonsStyling: false,
			})
		  }
		})
		return false;
	});
	/*Event Edit*/
	$(document).on("click",'#edit_event,.drawer-edit-close',function (e) {
		$(targetDrawer+'>div').toggleClass('d-none');
		return false;
	});
	/*Event Add*/
	$(document).on("click","#add_event",function (e) {
		setTimeout(function(){
			$('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
		},100);
		
		calendar.addEvent({
			backgroundColor: $('.cal-event-color').val(),
			borderColor: $('.cal-event-color').val(),
			title: $('.cal-event-name').val(),
			start: $('.cal-event-date-start').val(),
			end: $('.cal-event-date-end').val()
		});
		$.notify({
			icon: 'ri-checkbox-line mr-5',
			message: "Event has been created",
		},{	
			type: "dismissible alert alert-inv alert-inv-primary",
			placement: {
				from: "bottom",
				align: "center"
			},
			animate: {
				enter: 'animated fadeInUp',
				exit: 'animated fadeOutUp'
			},
			delay: 1000,
		});
		$('.cal-event-name').val("");
		//return false;
	});
});

/*Extra Costomization*/
setTimeout(function(){
	$('.fc-header-toolbar').append('<div class="hk-sidebar-togglable"></div>');
	$('.fc-today-button').removeClass('btn-primary').addClass('btn-outline-light');
	$('.fc-dayGridMonth-button,.fc-timeGridWeek-button,.fc-timeGridDay-button,.fc-listWeek-button').removeClass('btn-primary').addClass('btn-outline-light d-md-inline-block d-none');
	$('.fc-prev-button,.fc-next-button').addClass('btn-icon btn-flush-dark btn-rounded flush-soft-hover').find('.fa').addClass('icon');
	$('.fc-toolbar-chunk:nth-child(3)').append('<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover hk-navbar-togglable" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Collapse"><span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></span><span class="feather-icon d-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span></span></a>');
	$('.fc-prev-button,.fc-next-button').addClass('btn-icon btn-flush-dark btn-rounded flush-soft-hover').find('.fa').addClass('icon');
},100);
	


