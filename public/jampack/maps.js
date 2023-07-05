
("use strict");
if(ltlgOld[0] == ""){
    ltlgOld = [-8.1093477, 112.7086424];
}
const map = L.map("map", { scrollWheelZoom: false }).setView(ltlgOld, 15);

const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

const marker = L.marker(ltlgOld).addTo(map);

// Log to console

// const circle = L.circle(ltlgOld, {
//     color: "red",
//     fillColor: "#f03",
//     fillOpacity: 0.5,
//     radius: $("#radius").val(),
// }).addTo(map);

// FeatureGroup is to store editable layers
/* CONTORL MAPS */
var drawnItems = new L.FeatureGroup();
var ltlgPolygon = (
    $("[name=polygon]").val() != "" && $("[name=polygon]").val() != undefined
) ? JSON.parse($("[name=polygon]").val()) : [];
var polygon = L.polygon(ltlgPolygon, { color: "red" }).addTo(drawnItems);
map.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
    edit: {
        featureGroup: drawnItems,
    },
    draw: {
        // polygon: false,
        marker: false,
        rectangle:false,
        circle:false,
        polyline:false,
        circlemarker:false,
    },
});
map.addControl(drawControl);

map.on('draw:created',function (e) {
   var type = e.layerType,
       layer = e.layer;
//    if (type === 'marker') {
//        // Do marker specific actions
//    }
   // Do whatever else you need to. (save to db; add to map etc)
   $("[name=polygon]").val(JSON.stringify(layer.getLatLngs()));
   drawnItems.addLayer(layer);
});

/* END CONTORL MAPS */
clearAbjadAndSpasi("#koordinat")

$("#radius").on("change", function () {
    const range = $(this);
    circle.setRadius(range.val());
    $("#radius_count").val(range.val());
});

$("#koordinat").change(function (e) {
    e.preventDefault();
    clearAbjadAndSpasi("#koordinat")

    const val = $(this).val();
    const ltlg = val.split(",");

    updateMap(ltlg);

    $("#latitude").val(ltlg[0]);
    $("#longitude").val(ltlg[1]);

    // getCityName(ltlg[0],ltlg[1])
});
function updateMap(ltlg) {
    map.setView(ltlg, 15);
    var newLatLng = new L.LatLng(ltlg[0], ltlg[1]);
    marker.setLatLng(newLatLng);
    // marker.addTo(map);
    // circle.setLatLng(newLatLng);
}

function getCityName(latitude, longitude) {
    var url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + latitude + '&lon=' + longitude;

    fetch(url)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            var cityName = (data.address.city) ? "Kab. "+data.address.city : "Kec. "+data.address.county;
            console.log(cityName);
            $("#city").val(cityName) // Tampilkan nama kota di konsol
        })
        .catch(function(error) {
            console.log(error);
        });
}
function clearAbjadAndSpasi(el){
    var inputValue = $(el).val();
    // Menghapus spasi dan karakter abjad menggunakan regex
    var cleanedValue = inputValue.replace(/[\sA-Za-z]/g, '');
    $(el).val(cleanedValue);
}
