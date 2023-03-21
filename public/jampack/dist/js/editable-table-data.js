/*Editabletable Init*/
"use strict";
$('#edit_datable_1').editableTableWidget().numericInputExample().find('td:first').focus();
$('#edit_datable_2').editableTableWidget().numericInputExample().find('td:first').focus();
	
$(function(){
	$('#edit_datable_2').DataTable();
});
		