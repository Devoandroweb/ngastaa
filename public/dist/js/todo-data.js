/*Todo Init*/
"use strict"; 
$(function() {
	/*Repeater*/
	$('.repeater').repeater({
        defaultValues: {},
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function(setIndexes) {}
    });

	/*Id Add*/
	var edCnt=0;
	$('.editable').each(function(){
		$(this).attr('id','editable_'+edCnt);
		edCnt++;
	});
	function getEditorStatus (editorId) {
		return tinymce.get(editorId).mode.get();
	};
	function toggleEditorStatus (editorId, currentStatus) {
	if (currentStatus === "design") {
		tinymce.get(editorId).mode.set("readonly");
	} else {
		tinymce.get(editorId).mode.set("design");
	}
	};
	function enableDisable (targetEditor) {
	var status = getEditorStatus(targetEditor);
	toggleEditorStatus(targetEditor, status);
	};
	tinymce.init({
		selector: '.editable',
		inline: true,
		readonly: true,
		toolbar: false,
		menubar:false,
	});

	var selId,el,sel,range;
	$(document).on("click",".edit-tyn",function (e) {
		selId = $(this).closest('.inline-editable-wrap').find('.editable').attr('id');
		$(this).css('visibility','hidden');
		el = document.getElementById(selId);
		range = document.createRange();
		sel = window.getSelection();
		range.selectNodeContents(el);
		range.collapse(false);
		sel.removeAllRanges();
		sel.addRange(range);
		el.focus();
		enableDisable(selId);
		return false;
	});
	$(document).on("focusout",".editable",function (e) {
		enableDisable(selId);
		$('.edit-tyn').css('visibility','visible');
	});
	/*Radial*/
	var options6 = {
		series: [85],
		chart: {
			type: 'radialBar',
			width: 50,
			height: 50,
			sparkline: {
				enabled: true
			}
		},
		colors: ['#007D88'],
		dataLabels: {
			enabled: false
		},
		plotOptions: {
			radialBar: {
				hollow: {
					margin: 0,
					size: '80%'
				},
				track: {
					margin: 0,
					strokeWidth: '97%',
				},
			}
		},
			labels: ['8/12'],
			
	};

	var chart6 = new ApexCharts(document.querySelector("#sparkline_chart_7"), options6);
	chart6.render();

	/* Custom Dragula JS */
	dragula([document.getElementById("todo_list"),document.getElementById("todo_list_1")]);
	
	/* Custom Dragula JS */
	$(".advance-list .form-check-input").on( "click", function(e) {
		if ($(this).is( ":checked" )) {
			$(this).closest('li').addClass('selected');        
		} else {
			$(this).closest('li').removeClass('selected');
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
});