<select class="action" id="selectCar" onchange="change(value)"></select>

<script type="text/javascript">
    var url = `http://localhost:4000/cars?userId=<?php echo $_SESSION['userUid'] ?>`;
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var res = JSON.parse(xhr.responseText),
                data = res;
            var select_car = document.createElement("option");
            // select_car.value = "Select car";
            select_car.innerHTML = "Select car";
            document.getElementById("selectCar").appendChild(select_car);
            for(var i = 0; i < data.length; i++) {
                var ele = document.createElement("option");
                ele.value = data[i].vehicleNumber;
                ele.innerHTML = data[i].vehicleNumber;
                document.getElementById("selectCar").appendChild(ele);
            }
        }
    }
    xhr.open("GET", url, true);
    xhr.send();
</script>

    <script src="scripts\location.js" type="text/javascript"></script>
    <h1>Map</h1>
    <div id="map"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeXYVsBCW3H-2HOfIrHzCHndkXIVYPac8&callback=initMap"
        type="text/javascript"></script>

    
