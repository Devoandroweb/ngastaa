/*Gmap Init*/
"use strict";
/* Map initialization js*/
if( $('#map_canvas').length > 0 ){	
	 // When the window has finished loading create our google map below
		google.maps.event.addDomListener(window, 'load', init);
	
		function init() {
			var donca = {
				info: '<strong>Welcome to donca</strong>',
				lat: -37.7830,
				long: 145.1660
			};
			var melbo = {
				info: '<strong>Welcome to melbo</strong>',
				lat: -37.8136,
				long: 144.9631
			};

			

			var locations = [
			  [donca.info, donca.lat, donca.long, 0],
			  [melbo.info, melbo.lat, melbo.long, 1],
			  
			];
			// Basic options for a simple Google Map
			// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
			var mapOptions = {
				// How zoomed in you want the map to start at (always required)
				zoom: 11,

				// The latitude and longitude to center the map (always required)
				center: new google.maps.LatLng(-37.8136, 144.9631), // New York

				// How you would like to style the map. 
				// This is where you would paste any style found on Snazzy Maps.
				};

			// Get the HTML DOM element that will contain your map 
			// We are using a div with id="map" seen below in the <body>
			var mapElement = document.getElementById('map_canvas');
			
			// Create the Google Map using our element and options defined above
			var map = new google.maps.Map(mapElement, mapOptions);
			var contentString = '<div class="infowindow-wrap">'+
			'<h5 class="infowindow-header">Envato Pvt Ltd</h5>'+
			'<div class="infowindow-body"><p class="txt-dark mb-3">121 King Street, <br>Melbourne VIC 3000, Australia</p><a href="https://envato.com/" target="_blank">www.envato.com</a></div>'+
			'</div>';
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});	
			var marker, i;
			// Let's also add a marker while we're at it
			for (i = 0; i < locations.length; i++) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map,
				});

				google.maps.event.addListener(marker, 'click', (function (marker, i) {
					if(i === 2) {
						return false; 
					}
					else
						return function () {
							infowindow.open(map, marker);
						}
				})(marker, i));
				new google.maps.event.trigger( marker, 'click' );
			}
			
					
			
		}
}

