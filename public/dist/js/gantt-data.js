/*Gantt Init*/
$(function() {
    'use strict';
    /* Repeater*/
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

    /*Checkbox Add*/
    var tdCnt = 0;
    $('.gt-todo-table tbody tr').each(function() {
        $('<span class="form-check form-check-theme"><input type="checkbox" class="form-check-input check-select" id="chk_sel_' + tdCnt + '"><label class="form-check-label" for="chk_sel_' + tdCnt + '"></label></span>').insertBefore($(this).find("td > .gt-single-task >div").eq(0));
        tdCnt++;
    });

    /*Row Grouping*/
    var groupColumn = 2;
    var table_grp = $('#datable_1t').DataTable({
        "columnDefs": [{
            "visible": false,
            "targets": groupColumn
        }],
        responsive: false,
        autoWidth: false,
        "bPaginate": false,
        "info": false,
        "bFilter": false,
        language: {
            search: "",
            searchPlaceholder: "Search",
            sLengthMenu: "_MENU_items",
        },
        "order": [
            [groupColumn, 'asc']
        ],
        "displayLength": 25,
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(groupColumn, {
                page: 'current'
            }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td class="row-sep" colspan="5">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        }
    });

    // Order by the grouping
    $('#datable_1t tbody').on('click', 'tr.group', function() {
        var currentOrder = table_grp.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            table_grp.order([groupColumn, 'desc']).draw();
        } else {
            table_grp.order([groupColumn, 'asc']).draw();
        }
    });

    /*Select all using checkbox*/
    var DT1 = $('#datable_1t').DataTable();
    $(".check-select-all").on("click", function(e) {
        $('.check-select').attr('checked', true);
        if ($(this).is(":checked")) {
            DT1.rows().select();
            $('.check-select').prop('checked', true);
        } else {
            DT1.rows().deselect();
            $('.check-select').prop('checked', false);
        }
    });
    $(".check-select").on("click", function(e) {
        if ($(this).is(":checked")) {
            $(this).closest('tr').addClass('selected');
        } else {
            $(this).closest('tr').removeClass('selected');
            $('.check-select-all').prop('checked', false);
        }
    });

    /*Gantt*/
	 /*Split JS Init*/
    Split(['#split_1', '#split_2'], {
        gutter: function(index, direction) {
            var gutter = document.createElement('div')
            gutter.className = 'gutter gutter-' + direction
            gutter.style.height = '100%'
            return gutter
        },
        gutterSize: 7,
    })	
	var demoScroll = document.querySelector('#split_2 .simplebar-content-wrapper'); 
	
	var s = new Gantt("#gantt", [{
        id: "1",
        name: "Draft the new contract document for sales team",
        start: "2019-07-16",
        end: "2019-07-20",
        progress: 55
    }, {
        id: "2",
        name: "Find out the old contract documents",
        start: "2019-07-19",
        end: "2019-07-21",
        progress: 85,
        dependencies: "1"
    }, {
        id: "3",
        name: "Organize meeting with sales associates to understand need in detail",
        start: "2019-07-21",
        end: "2019-07-22",
        progress: 80,
        dependencies: "2"
    }, {
        id: "4",
        name: "iOS App home page",
        start: "2019-07-15",
        end: "2019-07-17",
        progress: 80
    }, {
        id: "5",
        name: "Write a release note",
        start: "2019-07-18",
        end: "2019-07-22",
        progress: 65,
        dependencies: "4"
    }, {
        id: "6",
        name: "Setup new sales project",
        start: "2019-07-20",
        end: "2019-07-31",
        progress: 15
    }, {
        id: "7",
        name: "Invite user to a project",
        start: "2019-07-25",
        end: "2019-07-26",
        progress: 99,
        dependencies: "6"
    }, {
        id: "8",
        name: "Coordinate with business development",
        start: "2019-07-28",
        end: "2019-07-30",
        progress: 35,
        dependencies: "7"
    }, {
        id: "9",
        name: "Kanban board design",
        start: "2019-08-01",
        end: "2019-08-03",
        progress: 25,
        dependencies: "8"
    }, {
        id: "10",
        name: "Enable analytics tracking",
        start: "2019-08-05",
        end: "2019-08-07",
        progress: 60,
        dependencies: "9"
    }], {
        view_modes: ["Quarter Day", "Half Day", "Day", "Week", "Month"],
        bar_height: 20,
        padding: 18,
        view_mode: "Week",
        custom_popup_html: function(e) {
            e.end, 60 <= e.progress || 30 <= e.progress && e.progress;
            return '<div class="popover fade show bs-popover-right gantt-task-details" role="tooltip"><div class="arrow"></div><div class="popover-body"><h5>${task.name}</h5><p class="mb-2">Expected to finish by ${end_date}</p><div class="progress mb-2" style="height: 10px;"><div class="progress-bar ${progressCls}" role="progressbar" style="width: ${task.progress}%;" aria-valuenow="${task.progress}" aria-valuemin="0" aria-valuemax="100">${task.progress}%</div></div></div></div>'
        }
    });
	var getOffset = $( ".bar" ).first();
	var offset = getOffset.offset().left;
	offset = offset/4;
	demoScroll.scrollTo({ left: offset, behavior: "smooth" });
    $("#modes-filter :input").on('change',function() {
        s.change_view_mode($(this).val());
		demoScroll.scrollTo({ left: offset, behavior: "smooth" });
	})
	
   

});