/*Contact Init*/
"use strict"; 
$(function() {
	/*Select2*/
	$("#input_tags_1,#input_tags_2,#input_tags_3").select2({
		tags: true,
		tokenSeparators: [',', ' ']
	});
	
	/*Dropify*/
	$('.dropify-1').dropify({
		  messages: {
			'default': 'Upload photo',
		},
		tpl: {
			message:'<div class="dropify-message"><span class="file-icon"></span> <p>{{ default }}</p></div>',
		}
	});
	if ($(".contact-card").length > 0) {
		/*Checkbox Add*/
		var tdCnt=0;
		$('.contact-card').each(function(){
			$('<span class="form-check form-check-lg"><input type="checkbox" class="form-check-input check-select" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></span>').insertBefore($(this).find(".card-action-wrap").eq(0));
			tdCnt++;
		});
	}
	/*DataTable Init*/
	if ($("#datable_1").length > 0) {
		/*Checkbox Add*/
		var tdCnt=0;
		$('table tr').each(function(){
			$('<span class="form-check mb-0"><input type="checkbox" class="form-check-input check-select" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></span>').insertBefore($(this).find("td > .d-flex .contact-star").eq(0));
			tdCnt++;
		});
		var targetDt = $('#datable_1').DataTable({
			"dom": '<"row"<"col-7 mb-3"<"contact-toolbar-left">><"col-5 mb-3"<"contact-toolbar-right"flip>>><"row"<"col-sm-12"t>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
			"ordering": true,
			"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				"targets": [0,7]
			} ],
			"order": [1, 'asc' ],
			language: { search: "",
				searchPlaceholder: "Search",
				"info": "_START_ - _END_ of _TOTAL_",
				sLengthMenu: "View  _MENU_",
				paginate: {
				  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
				  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
				}
			},
			"drawCallback": function () {
				$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
			}
		});
		$(document).on( 'click', '.del-button', function () {
			targetDt.rows('.selected').remove().draw( false );
			return false;
		});
		$("div.contact-toolbar-left").html('<div class="d-xxl-flex d-none align-items-center"> <select class="form-select form-select-sm w-120p"><option selected>Bulk actions</option><option value="1">Edit</option><option value="2">Move to trash</option></select> <button class="btn btn-sm btn-light ms-2">Apply</button></div><div class="d-xxl-flex d-none align-items-center form-group mb-0"> <label class="flex-shrink-0 mb-0 me-2">Sort by:</label> <select class="form-select form-select-sm w-130p"><option selected>Date Created</option><option value="1">Date Edited</option><option value="2">Frequent Contacts</option><option value="3">Recently Added</option> </select></div> <select class="d-flex align-items-center w-130p form-select form-select-sm"><option selected>Export to CSV</option><option value="2">Export to PDF</option><option value="3">Send Message</option><option value="4">Delegate Access</option> </select>');
		$("#datable_1").parent().addClass('table-responsive');
		
		/*Select all using checkbox*/
		var  DT1 = $('#datable_1').DataTable();
		$(".check-select-all").on( "click", function(e) {
			$('.check-select').attr('checked', true);
			if ($(this).is( ":checked" )) {
				DT1.rows().select();    
				$('.check-select').prop('checked', true);			
			} else {
				DT1.rows().deselect(); 
				$('.check-select').prop('checked', false);
			}
		});
		$(".check-select").on( "click", function(e) {
			if ($(this).is( ":checked" )) {
				$(this).closest('tr').addClass('selected');        
			} else {
				$(this).closest('tr').removeClass('selected');
				$('.check-select-all').prop('checked', false);
			}
		});
	}
});