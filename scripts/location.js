let map, marker=[], token='all';


$("#selectCar" ).change(function() {
    token = $('#selectCar').val();
    if ($('#selectCar').val() === "Select car") {
        token = 'all';
    }

    start();
});


async function getLocation() {
    if (token === 'all') {
        const response = await fetch(`http://localhost:4000/allcars`);
        const data = await response.json();
        return data;
    }
    const response = await fetch(`http://localhost:4000/api?token=${token}`);
    const data = await response.json();
    return data;
}

let isRunning = false;
const start = () => {
    initMap();
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
        let coords = await getLocation();
        for (let i = 0; i < coords.length; i++) {
            console.log(coords[i]);
            if (coords[i] === undefined) {
                return;
            }
            console.log(marker[i]);
            updateMarkerPosition(coords[i], marker[i]);
        }
        
        // console.log(`Location updated to coords: lat: ${coords[0].lat}, lng ${coords[0].lng}`);
    }, 1000);
}


async function initMap (cords = null, i = 0) {
    let coords;
    if(cords){
        coords=cords;
    }
    else {
        console.log('iau locatia');

        coords = await getLocation();

        const options = {
            zoom: 17,
            center: {lat: coords[0].lat, lng: coords[0].lng },
        };

        map = new google.maps.Map(document.getElementById('map'), options);
    }

    if (!coords[0]) {
        return;
    }

    const icon = {
        url: "https://getdrawings.com/free-icon/google-maps-bus-icon-55.png",
        scaledSize: new google.maps.Size(50, 50),
    };



    marker[i] = await setMarkerInitialPosition(coords[0], map, icon);



    if (coords.length) {
        console.log(`Masina ${coords}`);

        return initMap(coords.slice(1), ++i);
    }
}

function updateMarkerPosition (coords, marker) {
    if (coords === undefined) {
        return;
    }
    var latlng = new google.maps.LatLng(coords.lat, coords.lng);
    marker.setPosition(latlng);
}

async function setMarkerInitialPosition (coords, map, icon) {
    const infoText = coords.token +" "+ coords.denumire;

    const info = new google.maps.InfoWindow({ content: infoText });

    const mrkr = await new google.maps.Marker({
        position: {lat: coords.lat, lng: coords.lng },
        map: map,
        icon: icon,
    })

    mrkr.addListener('click', function() {
        info.open(map, mrkr);
    })

    return mrkr;
}

// $(document).ready(function() {
//     start();

// });

// $('#selectCar').on('click', function() {
//     alert( this.value );
//   });

