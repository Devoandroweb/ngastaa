/*DataTable Init*/
"use strict"; 
$(function() {
	$('#datable_1').DataTable( {
        scrollX:  true,
		autoWidth: false,
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_items",
			paginate: {
				next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
				previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});

	$('#datable_2').DataTable( {
       	scrollY:        "400px",
        scrollX:        true,
		language: { search: "",
			searchPlaceholder: "Search",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});
	
	$('#datable_3').DataTable( {
		rowReorder: true,
		scrollX:true,
		//scrollX:true,
		autoWidth: false,
		"order": [[ 1, "asc" ]],
		columnDefs: [
            { orderable: true, className: 'reorder', targets: 0 }
        ],
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_items",
			paginate: {
				next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
				previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});
	
	/*Export DataTable*/
	$('#datable_31').DataTable( {
		scrollX:  true,
		autoWidth: false,
		dom: 'Bfrtip',
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_items",
			paginate: {
				next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
				previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"info":     false,
		"bFilter":  false,
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	} );
	$('#datable_31_wrapper .dt-buttons > .btn').addClass('btn-outline-light btn-sm');
		
	
	/*MultiRow DataTable*/
	var targetElem = $('#datable_4');
	var targetDt =targetElem.DataTable({
		scrollX:  true,
		autoWidth: false,
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_items",
			paginate: {
				next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
				previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		select: {
			style: 'multi'
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});
	$(document).on( 'click', '.del-button', function () {
		targetDt.rows('.selected').remove().draw( false );
	});
	$('<button class="btn btn-soft-primary btn-sm del-button ms-3">Delete row</button>').insertAfter(targetElem.closest('#datable_4_wrapper').find('.dataTables_length label'));
	
	/*MultiRow Select Checkbox*/
	/*Checkbox Add*/
	var tdCnt=0;
    $(' table#datable_4c tbody tr').each(function(){
        $('<td><span class="form-check"><input type="checkbox" class="form-check-input" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></span></td>').prependTo($(this));
        tdCnt++;
    });
	/*DataTable Init*/
	var targetDt1 = $('#datable_4c').DataTable({
		scrollX:  true,
		autoWidth: false,
		"columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
		language: { search: "",
		searchPlaceholder: "Search",
		sLengthMenu: "_MENU_items",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});
	/*Select all using checkbox*/
	$(".check-select-all").on( "click", function(e) {
		$('.form-check-input').attr('checked', true);
		if ($(this).is( ":checked" )) {
			targetDt1.rows().select();    
			$('.form-check-input').prop('checked', true);			
		} else {
			targetDt1.rows().deselect(); 
			$('.form-check-input').prop('checked', false);
		}
	});
	$(".form-check-input").on( "click", function(e) {
		if ($(this).is( ":checked" )) {
			$(this).closest('tr').addClass('selected');        
		} else {
			$(this).closest('tr').removeClass('selected');
			$('.check-select-all').prop('checked', false);
		}
	});
	
	/*Row Grouping*/
	var groupColumn = 2;
		var table_grp = $('#datable_6').DataTable({
		"columnDefs": [
			{ "visible": false, "targets": groupColumn }
		],
		scrollX:  true,
		autoWidth: false,
		language: { search: "",
		searchPlaceholder: "Search",
		sLengthMenu: "_MENU_items",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}

		},
		"order": [[ groupColumn, 'asc' ]],
		"displayLength": 25,
		"drawCallback": function ( settings ) {
			var api = this.api();
			var rows = api.rows( {page:'current'} ).nodes();
			var last=null;

			api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
				if ( last !== group ) {
					$(rows).eq( i ).before(
						'<tr class="group"><td colspan="5">'+group+'</td></tr>'
					);

					last = group;
				}
			} );
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	} );
	// Order by the grouping
	$('#datable_6 tbody').on( 'click', 'tr.group', function () {
		var currentOrder = table_grp.order()[0];
		if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
			table_grp.order( [ groupColumn, 'desc' ] ).draw();
		}
		else {
			table_grp.order( [ groupColumn, 'asc' ] ).draw();
		}
	});
	
	/*Footer Callback*/
	$('#datable_7').DataTable( {
		scrollX:  true,
		autoWidth: false,
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_item",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            var total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            var pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+pageTotal +' ( $'+ total +' total)'
            );
        },
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});
			
	/*Add New Row*/
	var targetElem_1 = $('#datable_10');
	var targetDt2 = $('#datable_10').DataTable({
		scrollX:  true,
		autoWidth: false,
		language: { search: "",
		searchPlaceholder: "Search",
		sLengthMenu: "_MENU_items",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
	});
    var counter = 1;
	$('<button id="add_row" class="btn btn-soft-primary btn-sm ms-2">Add row</button>').insertAfter(targetElem_1.closest('#datable_10_wrapper').find('.dataTables_length label'));
	
	 $('#add_row').on( 'click', function () {
        targetDt2.row.add( [
            counter +'.1',
            counter +'.2',
            counter +'.3',
            counter +'.4',
            counter +'.5'
        ] ).draw( false );
 
        counter++;
    });
	
    // Automatically add a first row of data
    $('#add_row').trigger('click');
	
	/*Individual Column Searching*/
	$('#datable_11').DataTable( {
		orderCellsTop: true,
		scrollX:  true,
		autoWidth: false,
		language: { search: "",
		searchPlaceholder: "Search",
		sLengthMenu: "_MENU_items",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		initComplete: function () {
		  var api = this.api();
			$('.filterhead', api.table().header()).each( function (i) {
			  var column = api.column(i);
				var select = $('<select class="form-select form-select-sm" ><option value="">Show All</option></select>')
					.appendTo( $(this).empty() )
					.on( 'change', function () {
						var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
						);

						column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
					} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' );
				} );
			} );
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		}
    });
	
	/*Form Input*/
	var targetElem_2 = $('#datable_12');
	var table = $('#datable_12').DataTable({
		scrollX:  true,
		autoWidth: false,
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_items",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
			$('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
		},
        columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }]
    });
	$('<button id="add_data" class="btn btn-soft-primary btn-sm ms-2">Add row</button>').insertAfter(targetElem_2.closest('#datable_12_wrapper').find('.dataTables_length label'));
		$('#add_data').on( 'click', function () {
        var data = table.$('input, select').serialize();
        alert(
            "The following data would have been submitted to the server: \n\n"+
            data.substr( 0, 120 )+'...'
        );
        return false;
    });
		
	/*Index Column*/
	$('#datable_14').removeAttr('width').DataTable({ 
		scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns: true,
		language: { search: "",
			searchPlaceholder: "Search",
			sLengthMenu: "_MENU_items",
		},
	});
	
	/*Apply custom classes */
	$('.dataTables_length').addClass('mb-md-0 mb-2');
	
});




