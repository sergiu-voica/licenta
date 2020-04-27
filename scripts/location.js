let map, marker;

async function getLocation() {
    const response = await fetch('http://192.168.1.10:4000/api');

    const data = await response.json();
    return data;
}

let isRunning = false;
const start = () => {
    if(!isRunning) {
        isRunning = true;
        updateLocation();
    }
}

const updateLocation = () => {
    if(!isRunning) {
        return;
    }

    setInterval(async () => {
        const coords = await getLocation();
        updateMarkerPosition(coords, marker);
        console.log(`Location updated to coords: lat: ${coords.lat}, lng ${coords.long}`);
    }, 10000);
}

async function initMap () {
    const coords = await getLocation();
    console.log(coords);
    console.log(coords.lat);
    console.log(coords.long);
    const options = {
        zoom: 17,
        center: {lat: coords.lat, lng: coords.long },
    };

    const icon = {
        url: "https://getdrawings.com/free-icon/google-maps-bus-icon-55.png",
        scaledSize: new google.maps.Size(50, 50),
    };  

    map = new google.maps.Map(document.getElementById('map'), options);
    marker = await setMarkerInitialPosition(coords, map, icon);
}

function updateMarkerPosition (coords, marker) {
    var latlng = new google.maps.LatLng(coords.lat, coords.long);
    marker.setPosition(latlng);
}

function setMarkerInitialPosition (coords, map, icon) {
    return new google.maps.Marker({
        position: {lat: coords.lat, lng: coords.long },
        map: map,
        icon: icon,
    })
}

$(document).ready(function() {
    start();
});