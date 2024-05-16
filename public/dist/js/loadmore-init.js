/*Load More*/
$(".target-load-element:gt(3)").hide(); 
$(document).on("click",'.load-more',function (e) {
	e.preventDefault();
	$($(this).data('target')).find(".target-load-element:hidden").slice(0, 2).fadeIn('fast');
    if($(".target-load-element:hidden").length == 0) {
      $(this).text("No Content").addClass("disabled");
    }
});
