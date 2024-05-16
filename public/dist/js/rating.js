/*Rating Init*/
$(function() {
	//$(".my-rating-2").starRating({ initialRating: 4, starSize: 25 });
	$(".my-rating-2").starRating({
		tooltipActive: false,
		disableAfterRate: false
	});
	$(".my-rating-1").starRating({
		disableAfterRate: false
	});
	
	$(".my-rating-3").starRating({
		useFullStars: true,
		disableAfterRate: false
	});

	$(".my-rating-4").starRating({
		readOnly: true,
		disableAfterRate: false
	});
	$(".my-rating-5").starRating({
		tooltipActive: true,
		disableAfterRate: false,
	});
	/*Stars Progressive*/
	/* 1. Visualizing things on Hover - See next part for action on click */
	$('.rating-progressive .jq-star').on('mouseover', function() {
		$(this).parent().addClass('rating-level-'+parseInt($(this).data('value'), 10));
	}).on('mouseout', function(){
		$(this).parent().removeClass (function (index, className) {
			return (className.match (/(^|\s)rating-level-\S+/g) || []).join(' ');
		});
	});

  
	/* 2. Action to perform on click */
	$('.rating-progressive .jq-star').on('click', function(){
		$(this).parent().attr('data-rating',$(this).data('value'));
	});
});
