/*Gallery Init*/
"use strict";
/*Checkbox Add*/
$(function() {
	var tdCnt=0;
	$('.gallery-body  .collapse-simple .col > a').each(function(){
		$('<div class="form-check form-check-lg"><input type="checkbox" class="form-check-input check-select" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></div>').appendTo($(this));
		tdCnt++;
	});
});

/***** LightGallery init start*****/	
$('.hk-gallery').lightGallery({  addClass: 'galleryapp-info-active',mode: 'lg-fade',selector: '.gallery-img',thumbnail:false,hash: false});
/***** LightGallery init end*****/
