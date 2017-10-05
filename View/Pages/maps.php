
<div id="map" style="height: 600px; width: 100%"></div>

<script>
    var customLabel = {
        restaurant: {
            label: 'R'
        },
        bar: {
            label: 'B'
        }
    };

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(-33.863276, 151.207977),
            zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

        // Change this depending on the name of your PHP or XML file
        downloadUrl('https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
                var name = markerElem.getAttribute('name');
                var address = markerElem.getAttribute('address');
                var type = markerElem.getAttribute('type');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));

                var infowincontent = document.createElement('div');
                var strong = document.createElement('strong');
                strong.textContent = name
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);
                var icon = customLabel[type] || {};
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    label: icon.label
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
            });
        });
    }



    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}


//    var customLabel = {
//        restaurant: {
//            label: 'R'
//        },
//        bar: {
//            label: 'B'
//        }
//    };
//
//    function initMap() {
//        var map = new google.maps.Map(document.getElementById('map'), {
//            center: {lat: -34.397, lng: 150.644},
//            zoom: 15
//        });
//        //var infoWindow  = new google.maps.InfoWindow({map: map});
//
//
//        // Try HTML5 geolocation.
//        if (navigator.geolocation) {
//            navigator.geolocation.getCurrentPosition(function(position) {
//                var pos = {
//                    lat: position.coords.latitude,
//                    lng: position.coords.longitude
//                };
//
//                //infoWindow.setPosition(pos);
//                //infoWindow.setContent('Location found.');
//                var marker      = new google.maps.Marker({
//                    icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
//                    position: pos,
//                    map: map,
//                    title: 'Hello World!'
//                });
//
//                map.setCenter(pos);
//                //marker.setMap();
//
//            }, function() {
//                handleLocationError(true, infoWindow, map.getCenter());
//            });
//        } else {
//            // Browser doesn't support Geolocation
//            handleLocationError(false, infoWindow, map.getCenter());
//        }
//    }
//
//    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
//        infoWindow.setPosition(pos);
//        infoWindow.setContent(browserHasGeolocation ?
//            'Error: The Geolocation service failed.' :
//            'Error: Your browser doesn\'t support geolocation.');
//    }


</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-M0IMpBPaMnq6OA55g6S9c0FT08WDf5w&callback=initMap" ></script>

<script src="https://apis.google.com/js/platform.js" async defer></script>