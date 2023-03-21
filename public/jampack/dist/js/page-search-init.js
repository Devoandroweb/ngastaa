/*Page Search Init*/
$(function(){
	$(".page-search").on("keyup", function() {
		var value1 = $(this).val().toLowerCase();
		$(".page-search-wrap .hk-section").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value1) > -1)
		});
	});
	
	$(".list-search").on("keyup", function() {
		var value2 = $(this).val().toLowerCase();
		$(".target-list-wrap li").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value2) > -1)
		});
	});
	
	$(".dropdown-search").on("keyup", function() {
		var value3 = $(this).val().toLowerCase();
		$(".target-dropdown-wrap .dropdown-item").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value3) > -1)
		});
	});
  
	$(".card-search").on("keyup", function() {
		var value4 = $(this).val().toLowerCase();
		$(".target-cards-wrap .card").parent().filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value4) > -1)
		});
	});
 	
});