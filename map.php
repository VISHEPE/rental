<?php

if (isset($_GET['address'])) {
    // Get the address from the URL parameter
    $selectedAddress = urldecode($_GET['address']);

    // Define the apartment data with addresses and corresponding coordinates
    $apartmentData = [
        'Appart1' => ['address' => '123 Main St, City 1', 'coords' => [-1.2904735, 36.8444237]],
        'Appart2' => ['address' => '456 Elm St, City 2', 'coords' => [-1.2612601, 36.8463694]],
        'Appart3' => ['address' => '789 Oak St, City 3', 'coords' => [-1.2705238, 36.8397859]],
        'Appart4' => ['address' => '101 Pine St, City 4', 'coords' => [-1.2949048, 36.8433760]],
        'Appart5' => ['address' => '555 Cedar St, City 5', 'coords' => [-1.2939078, 36.8458580]],
        'Appart6' => ['address' => '999 Birch St, City 6', 'coords' => [-1.2210456, 36.8554234]]
    ];

    // Initialize the coordinates for the selected address
    $selectedCoords = null;

    // Find the coordinates for the selected address
    foreach ($apartmentData as $apartment => $data) {
        if ($apartment === $selectedAddress) {
            $selectedCoords = $data['coords'];
            break;
        }
    }

    if ($selectedCoords !== null) {
        // The address was found, so you can display the map with the selected marker
        // Include the HTML and JavaScript code for the map display here
    } else {
        echo 'Address not found on the map.';
    }
} else {
    echo 'No address specified.';
}
?>
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
        var mymap = L.map('mapid').setView(<?php echo json_encode($selectedCoords); ?>, 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        // Create a marker for the selected address
        var selectedMarker = L.marker(<?php echo json_encode($selectedCoords); ?>).addTo(mymap);

        // You can add a popup to the marker to display additional information
        selectedMarker.bindPopup('Selected Address: <?php echo $selectedAddress; ?>');

        // Fly to the selected address with a specific zoom level
        mymap.flyTo(<?php echo json_encode($selectedCoords); ?>, 16);
    </script>
</body>
</html>
