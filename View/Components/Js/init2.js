var formStr = "<input type='text' id='novoLugar'/><input type='button' value='Adicionar' onclick='addPlace();' />"

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 15
    });
    //var infoWindow  = new google.maps.InfoWindow({map: map});

    function addPlace() {
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({map:map, position: infowindow.getPosition()});
        marker.htmlContent = document.getElementById('novoLugar').value;
        infowindow.close();
        google.maps.event.addListener(marker, 'click', function(evt) {
            infowindow.setContent(this.htmlContent);
            infowindow.open(map,marker);
        });
        google.maps.event.addListener(marker, 'rightclick', function() {
            this.setMap(null);
        });
    }

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            //infoWindow.setPosition(pos);
            //infoWindow.setContent('Location found.');
            var marker      = new google.maps.Marker({
                icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
                position: pos,
                map: map,
                title: 'Hello World!'
            });

            // var formStr = "<input type='text' id='text4mrkr' value='marker text'/>"
            // var infowindow = new google.maps.InfoWindow();
            // marker.addListener('click', function(pos) {
            //     map.getDiv()
            //     // infowindow.setContent(formStr);
            //     map.setCenter(marker.getPosition());
            //     console.log("click");
            // });



            var infowindow = new google.maps.InfoWindow();

            google.maps.event.addListener(map, 'click', function (e) {
                infowindow.setContent(formStr);
                infowindow.setPosition(e.latLng);
                infowindow.open(map);
                console.log(document);
            });

            map.setCenter(pos);
            //marker.setMap();

        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}


function addPlace() {
    var map = initMap();
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({map:map, position: infowindow.getPosition()});
    var a = $('#novoLugar').val();
    var b = $('#novoLugar').val(a);

    //aa = document.getElementById('novoLugar').value;
    console.log(formStr);
    console.log(document.getElementById('novoLugar').value);
    marker.htmlContent = document.getElementById('novoLugar').value;
    infowindow.close();
    google.maps.event.addListener(marker, 'click', function(evt) {
        infowindow.setContent(this.htmlContent);
        infowindow.open(map,marker);
    });
    google.maps.event.addListener(marker, 'rightclick', function() {
        this.setMap(null);
    });
}

