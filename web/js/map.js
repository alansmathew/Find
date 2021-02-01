mapboxgl.accessToken = 'pk.eyJ1IjoiYWxhbnNtYXRoZXciLCJhIjoiY2toajd6dXJjMG55MDJ5dnNndTkybjNiNiJ9.V9-hx2TNgdlWK8MvegCI2Q';
// navigator.geolocation.getCurrentPosition(successLocation,
//     errorLocation,{
//         enableHighAccuracy:true,
//     });

// function successLocation(position){
//     console.log(position),
//     setupMap([position.coords.longitude,position.coords.latitude]);
// }

// // setupMap([76.767928,9.370273]);

// function errorLocation(){
//     document.write("your location service is not enabled. Relaod this page and allow location services to use this website.")
// }

// function setupMap(latlon){
//     const map = new mapboxgl.Map({
//         container: 'map',
//         style: 'mapbox://styles/mapbox/streets-v11',
//         center:latlon,
//         zoom:10,
//     });
//     const nav = new mapboxgl.NavigationControl();
//     map.addControl(nav,'bottom-right');
// }


var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/mapbox/outdoors-v11',
    center: [76.767928,9.370273],
    zoom: 10
});
 
var locator = new mapboxgl.GeolocateControl({
    positionOptions: {
        enableHighAccuracy: true
    },
    trackUserLocation: true
});

var scale = new mapboxgl.ScaleControl({
    maxWidth: 80,
    unit: 'imperial'
});
map.addControl(scale,'bottom-right');  
scale.setUnit('metric');

const nav = new mapboxgl.NavigationControl();
map.addControl(nav,'bottom-right');

map.addControl(locator,'bottom-right');


// https://www.googleapis.com/geolocation/v1/geolocate?key=YOUR_API_KEY