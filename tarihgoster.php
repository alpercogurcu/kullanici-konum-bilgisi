<!DOCTYPE html>
<html>

<head>
    <title>Marker Clustering</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkUOdZ5y7hMm0yrcCQoCvLwzdM6M8s5qk"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>


    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script>
        function initMap() {

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: {
                    lat: 35.9025,
                    lng: 42.02683
                }
            });
            var infoWin = new google.maps.InfoWindow();
            // Add some markers to the map.
            // Note: The code uses the JavaScript Array.prototype.map() method to
            // create an array of markers based on a given "locations" array.
            // The map() method here has nothing to do with the Google Maps API.
            var markers = locations.map(function(location, i) {
                var marker = new google.maps.Marker({
                    position: location
                });
                google.maps.event.addListener(marker, 'click', function(evt) {
                    infoWin.setContent(location.info);
                    infoWin.open(map, marker);
                })
                return marker;
            });

            // Add a marker clusterer to manage the markers.
            var markerCluster = new MarkerClusterer(map, markers, {
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
            });

        }
        var locations = [

            <?php
             require('baglanti.php');
            if ($_POST) {
                $tarih = $_POST['tarih'];

                $konumgetir = $db->prepare("Select * from konumbilgileri where tarih LIKE ? ");
                $konumgetir->bindValue(1, "%" . $tarih . "%", PDO::PARAM_STR);
                $konumgetir->execute();
            } else {
                $konumgetir = $db->query("Select * from konumbilgileri");
               
            }

            if ($konumgetir->rowCount()) {
                foreach ($konumgetir as $konum) {
                    echo '{ lat: ' . $konum['enlem'] . ', lng: '. $konum['boylam'] .', info: "'.$konum['tarih'].' ----- Link: <a href=\' '.$konum['link'].' \'> '.$konum['link'] .'</a>"},';
                }
            }
           
            ?>

            /*

            {
            lat: -19.9286,
            lng: -43.93888,
            info: "marker 1"
            }, {
            lat: -19.85758,
            lng: -43.9668,
            info: "marker 2"
            }, {
            lat: -18.24587,
            lng: -43.59613,
            info: "marker 3"
            }, {
            lat: -20.46427,
            lng: -45.42629,
            info: "marker 4"
            }, {
            lat: -20.37817,
            lng: -43.41641,
            info: "marker 5"
            }, {
            lat: -20.09749,
            lng: -43.48831,
            info: "marker 6"
            }, {
            lat: -21.13594,
            lng: -44.26132,
            info: "marker 7"
            }, 
            */


        ];

        google.maps.event.addDomListener(window, "load", initMap);
    </script>
</head>

<body>

    <div>
        <form method="post" action="tarihgoster.php">
            Tarih Gir ( Gün / Ay)
            <input type="text" id="tarih" name="tarih" placeholder="13/04" />
            <input type="submit" value="Listele">

        </form>
    </div>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKVqoKfnjpy6EbdfqdSviM9ztXEq53aNc&callback=initMap&libraries=&v=weekly" async></script>
</body>

</html>