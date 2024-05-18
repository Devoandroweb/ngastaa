/*Treeview Init*/
// html demo
$(function() {
//invoke the method jstree();
// $("#jstree").jstree({"plugins" : [ "contextmenu" ]});
// bind to events triggered on the tree

});

$(function () {
$("#jstree").jstree({
	 "core" : {
	   // so that create works
	   "check_callback" : true
	 },
	"plugins" : [ "contextmenu" ]
  });
  
$("#jstree_1").jstree({
	"core" : {
	  "check_callback" : true
	},
	"plugins" : [ "contextmenu" , "dnd","checkbox" ]
});
		
$("#jstree_2").jstree({
	"plugins" : [ "search" ]
 });
var to = false;
$('#jstree_2_q').keyup(function () {
if(to) { clearTimeout(to); }
to = setTimeout(function () {
	var v = $('#jstree_2_q').val();
	$('#jstree_2').jstree(true).search(v);
}, 250);
});
$("#jstree_3").jstree({
	"core" : {
	  "check_callback" : true
	},
	"plugins" : [ "contextmenu" , "dnd","checkbox" ]
});

 setTimeout(function() {
	$("#jstree").jstree("open_all");
	$("#jstree_1").jstree("open_all");
	$("#jstree_2").jstree("open_all");
	$("#jstree_3").jstree("open_all");
}, 100);
});