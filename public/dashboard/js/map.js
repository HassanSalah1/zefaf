var map;
var marker = null;
var infowindow = null;

$(function () {
    var latlng;
    if (typeof editLatLng === 'undefined')
        latlng = new google.maps.LatLng(29.747799983089738, 30.80393137551667);
    else
        latlng = editLatLng;

    var myOptions = {
        zoom: 9,
        // minZoom: 16,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map"), myOptions);

    addmarker(latlng);

    // Define the LatLng coordinates for the polygon's path.
    var triangleCoords = [
        {lat: 29.859130396364865, lng: 48.39673612904221},
        {lat: 29.928581939963507, lng: 48.20172880482346},
        {lat: 29.954762012318486, lng: 48.063026412245335},
        {lat: 30.094282298406, lng: 47.703498757299485},
        {lat: 30.084595358909148, lng: 47.37954236419853},
        {lat: 30.041807677148093, lng: 47.28066541107353},
        {lat: 29.970453799192608, lng: 47.14608289154228},
        {lat: 29.51711914510612, lng: 46.9148206509833},
        {lat: 29.111188763312448, lng: 46.603358181584326},
        {lat: 29.023565152411468, lng: 47.44765739740774},
        {lat: 28.804782556846902, lng: 47.60695915522024},
        {lat: 28.645816936211073, lng: 47.62893181147024},
        {lat: 28.530053972919603, lng: 47.72506218256399},
        // south
        {lat: 28.52564004736397, lng: 47.70669955147537},
        {lat: 28.535697581225847, lng: 48.4316177543667},


    ];

    // Construct the polygon.
    // var bermudaTriangle = new google.maps.Polygon({
    //     paths: triangleCoords,
    //     strokeColor: '#FF0000',
    //     strokeOpacity: 0.8,
    //     strokeWeight: 2,
    //     fillColor: '#FF0000',
    //     fillOpacity: 0.07,
    //     clickable: true,
    // });
    // bermudaTriangle.setMap(map);

    google.maps.event.addListener(map, "click", function (e) {
        //lat and lng is available in e object
        var newLatLng = e.latLng;
        addmarker(newLatLng);
    });


});


function addmarker(lat) {
    if (marker != null)
        marker.setMap(null);
    marker = new google.maps.Marker({
        position: lat,
        title: 'marker',
        draggable: false,
        map: map
    });
    $('#general-form input[name=latitude]').val(lat.lat());
    $('#general-form input[name=longitude]').val(lat.lng());
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'latLng': lat
    }, function (results, status) {
        console.log(results[0].formatted_address);
        // if (infowindow != null) {
        //if doesn't exist then create a empty InfoWindow object
        infowindow = new google.maps.InfoWindow();
        // }
        //Set the content of InfoWindow
        infowindow.setContent(results[0].formatted_address);
        //Tie the InfoWindow to the market
        infowindow.open(map, marker);
    });

}
