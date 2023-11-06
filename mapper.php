<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
    }

    #mapid {
        position: absolute;
        top: 78px;
        bottom: 0;
        width: 100%;
        height: 700px;
        z-index: 0; /* Set a lower z-index to ensure the map is behind the header */
    }

    #header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #333; /* Example background color */
        color: #fff; /* Example text color */
        padding: 10px;
        text-align: center;
        z-index: 1; /* Set a higher z-index to ensure the header is above the map */
    }
</style>
<body>
    <?php include 'header.php' ?>
    <div class="map" id="mapid"></div>
    <script>
        var mymap = L.map('mapid').setView([-1.2921562, 36.8450486], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        coords = [[-1.2904735, 36.8444237], [-1.2612601, 36.8463694], [-1.2705238, 36.8397859], [-1.2949048, 36.8433760], [-1.2939078, 36.8458580], [-1.2210456, 36.8554234]];
        
        areas = ["60 m2", "40 m2", "90 m2", "50 m2", "50 m2", "40 m2"];
        image = ["app/uploads/city.png", "app/uploads/kenya.png", "app/uploads/keny.png", "app/uploads/city.png", "app/uploads/kenya.png", "app/uploads/city.png"];
        rooms = [2, 4, 3, 8, 7, 3];

        let l = coords.length;
        var aparts = [];

        for (let i = 0; i < l; ++i) {
            var pop = L.popup({
                closeOnClick: true
            }).setContent('<h4>Area:' + areas[i] + ' Rooms: ' + rooms[i] + '</h4><img src=' + image[i] + ' style="height:100px">');

            var marker = L.marker(coords[i]).addTo(mymap).bindPopup(pop);
            var toollip = L.tooltip({
                permanent: true
            }).setContent(rent[i]);
            marker.bindTooltip(toollip);

            aparts.push(marker);
        }

        // Add click event to the markers
        for (let i = 0; i < l; ++i) {
            aparts[i].on('click', function () {
                mymap.flyTo(coords[i], 16);
            });
        }
    </script>
</body>
</html>

