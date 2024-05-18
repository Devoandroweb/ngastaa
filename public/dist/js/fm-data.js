/*Fm Init*/
"use strict"; 
$(function() {
	if ($("#datable_1").length > 0) {
		/*Checkbox Add*/
		var tdCnt=0;
		$('table tr').each(function(){
			$('<span class="form-check mb-0"><input type="checkbox" class="form-check-input check-select" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></span>').insertBefore($(this).find("td > .d-flex .file-star").eq(0));
			tdCnt++;
		});
		
		/*DataTable Init*/
		var targetDt = $('#datable_1').DataTable({
			autoWidth: false,
			"ordering": true,
			"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				"targets": [0,5]
			} ],
			"order": [1, 'asc' ],
			"bPaginate": false,
			"info":     false,
			"bFilter":     false,
			"drawCallback": function () {
				$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple active-theme');
			}
		});
		
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