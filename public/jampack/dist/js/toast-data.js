/*Toast Init*/
$(function() {
	"use strict";
	$.toast().reset('all');
	$("body").removeAttr('class');
	$.toast({
		heading: 'Well done!',
		text: '<p>You have successfully completed level 1.</p><button class="btn btn-primary btn-sm mt-3">Play again</button>',
		position: 'top-right',
		loaderBg:'#00acf0',
		loader:false,
		class: 'jq-toast-primary',
		hideAfter: 3500, 
		stack: 6,
		showHideTransition: 'fade'
	});
	
	$('.tst1').on('click',function(e){
	    $.toast().reset('all'); 
		$("body").removeAttr('class');
		$.toast({
            text: '<i class="jq-toast-icon ti-twitter-alt"></i><p>John! Recently joined twitter.</p>',
			position: 'top-left',
			loaderBg:'#00acf0',
			class: 'jq-has-icon jq-toast-info',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
    });

	$('.tst2').on('click',function(e){
        $.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            heading: 'Are you sure you want to delete this file?',
			text: '<i class="jq-toast-icon ti-alert"></i><button class="btn btn-secondary btn-sm mt-3 me-2">yes</button><button class="btn btn-primary btn-sm mt-3">cancel</button>',
			position: 'top-right',
			loaderBg:'#00acf0',
			class: 'jq-has-icon jq-toast-warning',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tst3').on('click',function(e){
        $.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            text: '<i class="jq-toast-icon ti-location-pin"></i><p>John Doe started following your board.</p>',
			position: 'bottom-left',
			loaderBg:'#00acf0',
			class: 'jq-has-icon jq-toast-success',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
          });
		return false;  
	});

	$('.tst4').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            heading: 'Oh snap!',
			text: '<p>Change a few things and try submitting again.</p>',
			position: 'bottom-right',
			loaderBg:'#00acf0',
			class: 'jq-toast-danger',
			hideAfter: 3500, 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
    });
	
	$('.tsti1').on('click',function(e){
	    $.toast().reset('all'); 
		$("body").removeAttr('class');
		$.toast({
            text: '<i class="jq-toast-icon ti-twitter-alt"></i><p>John! Recently joined twitter.</p>',
			position: 'top-left',
			loaderBg:'#00acf0',
			class: 'jq-has-icon jq-toast-inv jq-toast-inv-info',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
    });

	$('.tsti2').on('click',function(e){
        $.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            heading: 'Are you sure you want to delete this file?',
			text: '<i class="jq-toast-icon ti-alert"></i><button class="btn btn-outline-white btn-sm mt-3 me-2">yes</button><button class="btn btn-outline-white btn-sm mt-3">cancel</button>',
			position: 'top-right',
			loaderBg:'#00acf0',
			class: 'jq-has-icon jq-toast-inv jq-toast-inv-warning',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tsti3').on('click',function(e){
        $.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            text: '<i class="jq-toast-icon ti-location-pin"></i><p>John Doe started following your board.</p>',
			position: 'bottom-left',
			loaderBg:'#00acf0',
			class: 'jq-has-icon jq-toast-inv jq-toast-inv-success',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
          });
		return false;  
	});

	$('.tsti4').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            heading: 'Oh snap!',
			text: '<p>Change a few things and try submitting again.</p>',
			position: 'bottom-right',
			loaderBg:'#00acf0',
			class: 'jq-toast-inv jq-toast-inv-danger',
			hideAfter: 3500, 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
    });
	
	$('.tst5').on('click',function(e){
	    $.toast().reset('all');   
		$("body").removeAttr('class');
		$.toast({
            heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-primary btn-sm mt-3">Play again</button>',
			position: 'top-left',
			loaderBg:'#00acf0',
			class: 'jq-toast-primary',
			loader:false,
			hideAfter: 3500, 
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
    });
	
	$('.tst6').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
            heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-primary btn-sm mt-3">Play again</button>',
			position: 'top-right',
			loaderBg:'#00acf0',
			class: 'jq-toast-primary',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
    });
	
	$('.tst7').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
		$.toast({
           heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-primary btn-sm mt-3">Play again</button>',
			position: 'bottom-left',
			loaderBg:'#00acf0',
			class: 'jq-toast-primary',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
    });
	
	$('.tst8').on('click',function(e){
	    $.toast().reset('all');   
		$("body").removeAttr('class');
		$.toast({
            heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-primary btn-sm mt-3">Play again</button>',
			position: 'bottom-right',
			loaderBg:'#00acf0',
			class: 'jq-toast-primary',
			hideAfter: 3500, 
			loader:false,
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tst9').on('click',function(e){
	    $.toast().reset('all');   
		$("body").removeAttr('class').removeClass("bottom-center-fullwidth").addClass("top-center-fullwidth");
		$.toast({
			text: '<div class="d-flex align-items-center justify-content-center"><p>Your Website uses cookies to ensure you to get the best experience on our website. <a href="#">Cookies Policy</a></p><button class="btn btn-sm btn-primary ms-3">Got It</button></div>',
			position: 'bottom-center',
			class: 'jq-toast-dark',
			hideAfter: false, 
			textAlign: 'center', 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tst10').on('click',function(e){
	    $.toast().reset('all');
		$("body").removeAttr('class').addClass("bottom-center-fullwidth");
		$.toast({
            text: '<p>Your plugin has an update available. <a href="#">Open Plugin Manager</u></p>',
			position: 'bottom-center',
			class: 'jq-toast-inv bg-theme',
			hideAfter: false, 
			textAlign: 'center', 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tst11').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
	    $.toast({
            heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-pink btn-sm mt-3">Play again</button>',
			position: 'top-right',
			loaderBg:'#00acf0',
			loader:false,
			class: 'bg-pink-light-5',
			hideAfter: 350000, 
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
	});
	$('.tst12').on('click',function(e){
	    $.toast().reset('all');
		$("body").removeAttr('class').addClass("bottom-center-fullwidth");
		$.toast({
            text: '<p>Your plugin has an update available. <a href="#">Open Plugin Manager</u></p>',
			position: 'bottom-center',
			class: 'bg-pink-light-5',
			hideAfter: false, 
			textAlign: 'center', 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tst13').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
	    $.toast({
            heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-primary btn-sm mt-3">Play again</button>',
			position: 'top-right',
			loaderBg:'#00acf0',
			loader:false,
			class: 'jq-toast-inv bg-dark',
			hideAfter: 350000, 
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
	});
	$('.tst14').on('click',function(e){
	    $.toast().reset('all');
		$("body").removeAttr('class').addClass("bottom-center-fullwidth");
		$.toast({
            text: '<p>Your plugin has an update available. <a href="#">Open Plugin Manager</u></p>',
			position: 'bottom-center',
			class: 'jq-toast-inv bg-blue',
			hideAfter: false, 
			textAlign: 'center', 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
	});
	
	$('.tst15').on('click',function(e){
		$.toast().reset('all');
		$("body").removeAttr('class');
	    $.toast({
            heading: 'Well done!',
			text: '<p>You have successfully completed level 1.</p><button class="btn btn-indigo btn-sm mt-3">Play again</button>',
			position: 'top-right',
			loaderBg:'#00acf0',
			loader:false,
			class: 'jq-toast-inv bg-gradient-heaven',
			hideAfter: 350000, 
			stack: 6,
			showHideTransition: 'fade'
        });
		return false;
	});
	$('.tst16').on('click',function(e){
	    $.toast().reset('all');
		$("body").removeAttr('class').addClass("bottom-center-fullwidth");
		$.toast({
            text: '<p>Your plugin has an update available. <a href="#">Open Plugin Manager</u></p>',
			position: 'bottom-center',
			class: 'jq-toast-inv bg-gradient-dusk',
			hideAfter: false, 
			textAlign: 'center', 
			stack: 6,
			loader:false,
			showHideTransition: 'fade'
        });
		return false;
	});
});
          
