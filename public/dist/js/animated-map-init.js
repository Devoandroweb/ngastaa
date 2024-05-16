/**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 * 
 * For more information visit:
 * https://www.amcharts.com/
 * 
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
var chart = am4core.create("anim_map_1", am4maps.MapChart);
chart.geodata = am4geodata_worldLow;
chart.projection = new am4maps.projections.Miller();
chart.homeZoomLevel = 2.5;
chart.homeGeoPoint = {
	latitude: 38,
	longitude: -60
};

// Create map polygon series
var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
polygonSeries.useGeodata = true;
polygonSeries.mapPolygons.template.fill = am4core.color("#E6E9EB");
polygonSeries.mapPolygons.template.nonScalingStroke = true;
polygonSeries.exclude = ["AQ"];

// Add line bullets
var cities = chart.series.push(new am4maps.MapImageSeries());
cities.mapImages.template.nonScaling = true;

var city = cities.mapImages.template.createChild(am4core.Circle);
city.radius = 6;
city.fill = am4core.color("#298DFF");
city.strokeWidth = 2;
city.stroke = am4core.color("#fff");

function addCity(coords, title) {
	var city = cities.mapImages.create();
	city.latitude = coords.latitude;
	city.longitude = coords.longitude;
	city.tooltipText = title;
	return city;
}

var paris = addCity({ "latitude": 48.8567, "longitude": 2.3510 }, "Paris");
var toronto = addCity({ "latitude": 43.8163, "longitude": -79.4287 }, "Toronto");
var la = addCity({ "latitude": 34.3, "longitude": -118.15 }, "Los Angeles");
var havana = addCity({ "latitude": 23, "longitude": -82 }, "Havana");

// Add lines
var lineSeries = chart.series.push(new am4maps.MapArcSeries());
lineSeries.mapLines.template.line.strokeWidth = 2;
lineSeries.mapLines.template.line.strokeOpacity = 0.5;
lineSeries.mapLines.template.line.stroke = am4core.color("#298DFF");
lineSeries.mapLines.template.line.nonScalingStroke = true;
lineSeries.mapLines.template.line.strokeDasharray = "1,1";
lineSeries.zIndex = 10;

var shadowLineSeries = chart.series.push(new am4maps.MapLineSeries());
shadowLineSeries.mapLines.template.line.strokeOpacity = 0;
shadowLineSeries.mapLines.template.line.nonScalingStroke = true;
shadowLineSeries.mapLines.template.shortestDistance = false;
shadowLineSeries.zIndex = 5;

function addLine(from, to) {
	var line = lineSeries.mapLines.create();
	line.imagesToConnect = [from, to];
	line.line.controlPointDistance = -0.3;

	var shadowLine = shadowLineSeries.mapLines.create();
	shadowLine.imagesToConnect = [from, to];

	return line;
}

addLine(paris, toronto);
addLine(toronto, la);
addLine(la, havana);

// Add plane
var plane = lineSeries.mapLines.getIndex(0).lineObjects.create();
plane.position = 0;
plane.width = 48;
plane.height = 48;

plane.adapter.add("scale", (scale, target) => {
	return 0.5 * (1 - (Math.abs(0.5 - target.position)));
})

var planeImage = plane.createChild(am4core.Sprite);
planeImage.scale = 0.08;
planeImage.horizontalCenter = "middle";
planeImage.verticalCenter = "middle";
planeImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
planeImage.fill = am4core.color("#1F2327");
planeImage.strokeOpacity = 0;

var shadowPlane = shadowLineSeries.mapLines.getIndex(0).lineObjects.create();
shadowPlane.position = 0;
shadowPlane.width = 48;
shadowPlane.height = 48;

var shadowPlaneImage = shadowPlane.createChild(am4core.Sprite);
shadowPlaneImage.scale = 0.05;
shadowPlaneImage.horizontalCenter = "middle";
shadowPlaneImage.verticalCenter = "middle";
shadowPlaneImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
shadowPlaneImage.fill = am4core.color("#000");
shadowPlaneImage.strokeOpacity = 0;

shadowPlane.adapter.add("scale", (scale, target) => {
	target.opacity = (0.6 - (Math.abs(0.5 - target.position)));
	return 0.5 - 0.3 * (1 - (Math.abs(0.5 - target.position)));
})

// Plane animation
var currentLine = 0;
var direction = 1;
function flyPlane() {

	// Get current line to attach plane to
	plane.mapLine = lineSeries.mapLines.getIndex(currentLine);
	plane.parent = lineSeries;
	shadowPlane.mapLine = shadowLineSeries.mapLines.getIndex(currentLine);
	shadowPlane.parent = shadowLineSeries;
	shadowPlaneImage.rotation = planeImage.rotation;

	// Set up animation
	var from, to;
	var numLines = lineSeries.mapLines.length;
	if (direction == 1) {
		from = 0
		to = 1;
		if (planeImage.rotation != 0) {
			planeImage.animate({ to: 0, property: "rotation" }, 1000).events.on("animationended", flyPlane);
			return;
		}
	}
	else {
		from = 1;
		to = 0;
		if (planeImage.rotation != 180) {
			planeImage.animate({ to: 180, property: "rotation" }, 1000).events.on("animationended", flyPlane);
			return;
		}
	}

	// Start the animation
	var animation = plane.animate({
		from: from,
		to: to,
		property: "position"
	}, 5000, am4core.ease.sinInOut);
	animation.events.on("animationended", flyPlane)
	/*animation.events.on("animationprogress", function(ev) {
	  var progress = Math.abs(ev.progress - 0.5);
	  //console.log(progress);
	  //planeImage.scale += 0.2;
	});*/

	shadowPlane.animate({
		from: from,
		to: to,
		property: "position"
	}, 5000, am4core.ease.sinInOut);

	// Increment line, or reverse the direction
	currentLine += direction;
	if (currentLine < 0) {
		currentLine = 0;
		direction = 1;
	}
	else if ((currentLine + 1) > numLines) {
		currentLine = numLines - 1;
		direction = -1;
	}

}

// Go!
flyPlane();

/**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 * 
 * For more information visit:
 * https://www.amcharts.com/
 * 
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end


// Create map instance
var chart1 = am4core.create("anim_map_3", am4maps.MapChart);

// Set map definition
chart1.geodata = am4geodata_worldHigh;

// Set projection
chart1.projection = new am4maps.projections.Mercator();

// Center on the groups by default
chart1.homeZoomLevel = 6;
chart1.homeGeoPoint = { longitude: 10, latitude: 51 };

// Polygon series
var polygonSeries = chart1.series.push(new am4maps.MapPolygonSeries());
polygonSeries.exclude = ["AQ"];
polygonSeries.useGeodata = true;
polygonSeries.mapPolygons.template.fill = am4core.color("#E6E9EB");
polygonSeries.nonScalingStroke = true;
polygonSeries.strokeOpacity = 0.5;

// Image series
var imageSeries = chart1.series.push(new am4maps.MapImageSeries());
var imageTemplate = imageSeries.mapImages.template;
imageTemplate.propertyFields.longitude = "longitude";
imageTemplate.propertyFields.latitude = "latitude";
imageTemplate.nonScaling = true;

var image = imageTemplate.createChild(am4core.Image);
image.propertyFields.href = "imageURL";
image.width = 50;
image.height = 50;
image.horizontalCenter = "middle";
image.verticalCenter = "middle";

var label = imageTemplate.createChild(am4core.Label);
label.text = "{label}";
label.horizontalCenter = "middle";
label.verticalCenter = "top";
label.dy = 20;

imageSeries.data = [{
  "latitude": 40.416775,
  "longitude": -3.703790,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/rainy-1.svg",
  "width": 32,
  "height": 32,
  "label": "Madrid: +22C"
}, {
  "latitude": 48.856614,
  "longitude": 2.352222,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/thunder.svg",
  "width": 32,
  "height": 32,
  "label": "Paris: +18C"
}, {
  "latitude": 52.520007,
  "longitude": 13.404954,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/cloudy-day-1.svg",
  "width": 32,
  "height": 32,
  "label": "Berlin: +13C"
}, {
  "latitude": 52.229676,
  "longitude": 21.012229,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/day.svg",
  "width": 32,
  "height": 32,
  "label": "Warsaw: +22C"
}, {
  "latitude": 41.872389,
  "longitude": 12.480180,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/day.svg",
  "width": 32,
  "height": 32,
  "label": "Rome: +29C"
}, {
  "latitude": 51.507351,
  "longitude": -0.127758,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/rainy-7.svg",
  "width": 32,
  "height": 32,
  "label": "London: +10C"
}, {
  "latitude": 59.329323,
  "longitude": 18.068581,
  "imageURL": "https://www.amcharts.com/lib/images/weather/animated/rainy-1.svg",
  "width": 32,
  "height": 32,
  "label": "Stockholm: +8C"
} ];




am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
var chart2 = am4core.create("anim_map_2", am4maps.MapChart);

// Set map definition
chart2.geodata = am4geodata_worldLow;

// Set projection
chart2.projection = new am4maps.projections.Miller();

// Create map polygon series
var polygonSeries = chart2.series.push(new am4maps.MapPolygonSeries());
polygonSeries.mapPolygons.template.fill = am4core.color("#E6E9EB");
polygonSeries.mapPolygons.template.fillOpacity = 1;
// Exclude Antartica
polygonSeries.exclude = ["AQ"];

// Make map load polygon (like country names) data from GeoJSON
polygonSeries.useGeodata = true;

// Configure series
var polygonTemplate = polygonSeries.mapPolygons.template;
polygonTemplate.tooltipText = "{name}";


// Create hover state and set alternative fill color
var hs = polygonTemplate.states.create("hover");
hs.properties.fill = am4core.color("#CCE5E7");

// Add image series
var imageSeries = chart2.series.push(new am4maps.MapImageSeries());
imageSeries.mapImages.template.propertyFields.longitude = "longitude";
imageSeries.mapImages.template.propertyFields.latitude = "latitude";
imageSeries.mapImages.template.tooltipText = "{title}";
imageSeries.mapImages.template.propertyFields.url = "url";

var circle = imageSeries.mapImages.template.createChild(am4core.Circle);
circle.radius = 3;
circle.propertyFields.fill = "color";

var circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
circle2.radius = 3;
circle2.propertyFields.fill = "color";


circle2.events.on("inited", function(event){
  animateBullet(event.target);
})


function animateBullet(circle) {
    var animation = circle.animate([{ property: "scale", from: 1, to: 5 }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
    animation.events.on("animationended", function(event){
      animateBullet(event.target.object);
    })
}

var colorSet = new am4core.ColorSet();

imageSeries.data = [ {
  "title": "Brussels",
  "latitude": 50.8371,
  "longitude": 4.3676,
  "color":'#298dff'
}, {
  "title": "Copenhagen",
  "latitude": 55.6763,
  "longitude": 12.5681,
   "color":'#298dff'
}, {
  "title": "Paris",
  "latitude": 48.8567,
  "longitude": 2.3510,
  "color":'#298dff'
}, {
  "title": "Reykjavik",
  "latitude": 64.1353,
  "longitude": -21.8952,
   "color":'#298dff'
}, {
  "title": "Moscow",
  "latitude": 55.7558,
  "longitude": 37.6176,
   "color":'#298dff'
}, {
  "title": "Madrid",
  "latitude": 40.4167,
  "longitude": -3.7033,
   "color":'#298dff'
}, {
  "title": "London",
  "latitude": 51.5002,
  "longitude": -0.1262,
  "url": "http://www.google.co.uk",
   "color":'#298dff'
}, {
  "title": "Peking",
  "latitude": 39.9056,
  "longitude": 116.3958,
  "color":'#298dff'
}, {
  "title": "New Delhi",
  "latitude": 28.6353,
  "longitude": 77.2250,
   "color":'#298dff'
}, {
  "title": "Tokyo",
  "latitude": 35.6785,
  "longitude": 139.6823,
  "url": "http://www.google.co.jp",
  "color":'#298dff'
}, {
  "title": "Ankara",
  "latitude": 39.9439,
  "longitude": 32.8560,
   "color":'#298dff'
}, {
  "title": "Buenos Aires",
  "latitude": -34.6118,
  "longitude": -58.4173,
   "color":'#298dff'
}, {
  "title": "Brasilia",
  "latitude": -15.7801,
  "longitude": -47.9292,
   "color":'#298dff'
}, {
  "title": "Ottawa",
  "latitude": 45.4235,
  "longitude": -75.6979,
   "color":'#298dff'
}, {
  "title": "Washington",
  "latitude": 38.8921,
  "longitude": -77.0241,
   "color":'#298dff'
}, {
  "title": "Kinshasa",
  "latitude": -4.3369,
  "longitude": 15.3271,
   "color":'#298dff'
}, {
  "title": "Cairo",
  "latitude": 30.0571,
  "longitude": 31.2272,
  "color":'#298dff'
}, {
  "title": "Pretoria",
  "latitude": -25.7463,
  "longitude": 28.1876,
   "color":'#298dff'
} ];



}); // end am4core.ready()