/*Hopscotch Init*/
$(window).on("load",function(){
	
		// Define the tour!
		var tour = {
		  id: "hopscotch-light",
		  steps: [
			{
				target: "doc-list",
				placement: 'bottom',
				title: 'Search in docs',
				content: "Search about components from this forms.",
			},
			{
				target: "get-support",
				placement: 'left',
				title: 'Get support',
				content: "Get the best support by team Nubra UI.",
			},
			{
				target: "jump-to",
				placement: "left",
				title: "Jump to",
				content: "Jump to any section according to your requirement.",
			  
			}
		  ],
		  showPrevButton: true,
		};

		// Start the tour!
		hopscotch.startTour(tour);
		
});