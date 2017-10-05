var formStr = "<div class='container' id='divAdd' style='width: 200px'><span style='text-align: center; font-weight: bold;'>Deseja adicionar esse local?</span></br><input class='btn btn-primary' type='button' id='btnAddNovoLugar' data-toggle=\"modal\" data-target=\"#modalAddNovoLugar\" style='margin-top: 20px;' value='Adicionar'/></div>"
var latitude;
var longitude;
var map;
var markers = [];
var newMarker;
var infowindow;

var customLabel = {
    restaurant: {
        label: 'R'
    },
    bar: {
        label: 'B'
    }
};

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(-33.863276, 151.207977),
        zoom: 15
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var marker      = new google.maps.Marker({
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                position: pos,
                map: map,
                title: 'Estou Aqui!'
            });

            infowindow = new google.maps.InfoWindow();

            google.maps.event.addListener(map, 'click', function (e) {
                infowindow.setContent(formStr);
                infowindow.setPosition(e.latLng);
                latitude    = e.latLng.lat();
                longitude   = e.latLng.lng();
                infowindow.open(map);
            });

            // Change this depending on the name of your PHP or XML file
            downloadUrl('../../dao/xml.php', function(data) {
                var xml = data.responseXML;
                markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                    var name = markerElem.getAttribute('nome');
                    var id = markerElem.getAttribute('id');
                    var address = markerElem.getAttribute('descricao');

                    //var type = markerElem.getAttribute('type');
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
                    var imagem = document.createElement("img");
                    infowincontent.appendChild(imagem);
                    //alert(data.responseText);
                    var content22 = '<div id="iw-container">';
                    content22.concat('<div class="iw-title">'+markerElem.getAttribute('nome')+'</div>');
                    content22.concat('<div class="iw-content">');
                    //content22.concat('<img src="'+markerElem.getAttribute('imagem')+'" alt="'+markerElem.getAttribute('nome')+'" height="115" width="83">');
                    content22.concat('<div class="iw-subTitle">Descrição</div>');
                    content22.concat('<p>'+markerElem.getAttribute('descricao')+'</p>');
                    content22.concat('</div>');
                    content22.concat('<div class="iw-bottom-gradient"></div>');
                    content22.concat('</div>');

                    var contentString = '<div class="info-window">' +
                        '<h2>'+markerElem.getAttribute('nome')+'</h2>' +
                        '<div class="info-content">' +
                        '<p>'+markerElem.getAttribute('descricao')+'</p>';
                    if(markerElem.getAttribute('privado') == 0){
                        contentString+= '<p><button type="button" class="btn btn-success btn-xs"> Público </button></p>';
                    }else {
                        contentString+=  '<p><button type="button" class="btn btn-warning btn-xs"> Privado </button></p>';
                    }
                    contentString+=    '</div></div>';
                    //var icon = customLabel[type] || {};
                    newMarker = new google.maps.Marker({
                        map: map,
                        position: point
                        //label: icon.label
                    });
                    var infoWindow = new google.maps.InfoWindow({
                       content: contentString
                    });
                    newMarker.addListener('click', function() {
                        infoWindow.open(map, this);
                    });
                });
            });
            map.setCenter(pos);


        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }


    //var infoWindow = new google.maps.InfoWindow;


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




// var formStr = "<div class='container' id='divAdd' style='width: 200px'><spam style='text-align: center; font-weight: bold;'>Deseja adicionar esse local?</spam></br><input class='btn btn-primary' type='button' id='btnAddNovoLugar' data-toggle=\"modal\" data-target=\"#modalAddNovoLugar\" style='margin-top: 20px;' value='Sim'/><input class='btn btn-danger' type='button' id='btnNaoAdd' style='margin-left: 45px; margin-top: 20px;' value='Não'/></div>"
// var latitude;
// var longitude;
//
// function initMap() {
//     var map = new google.maps.Map(document.getElementById('map'), {
//         center: {lat: -34.397, lng: 150.644},
//         zoom: 15
//     });
//
//     // Try HTML5 geolocation.
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(function(position) {
//             var pos = {
//                 lat: position.coords.latitude,
//                 lng: position.coords.longitude
//             };
//
//             var marker      = new google.maps.Marker({
//                 icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
//                 position: pos,
//                 map: map,
//                 title: 'Hello World!'
//             });
//
//             var infowindow = new google.maps.InfoWindow();
//
//             google.maps.event.addListener(map, 'click', function (e) {
//                 infowindow.setContent(formStr);
//                 infowindow.setPosition(e.latLng);
//                 latitude    = e.latLng.lat();
//                 longitude   = e.latLng.lng();
//                 infowindow.open(map);
//             });
//
//             map.setCenter(pos);
//
//         }, function() {
//             handleLocationError(true, infoWindow, map.getCenter());
//         });
//     } else {
//         // Browser doesn't support Geolocation
//         handleLocationError(false, infoWindow, map.getCenter());
//     }
// }
//
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

    marker.htmlContent = document.getElementById('nomeLocal').value;
    infowindow.close();
    google.maps.event.addListener(marker, 'click', function(evt) {
        infowindow.setContent(this.htmlContent);
        infowindow.open(map,marker);
    });
    // google.maps.event.addListener(marker, 'rightclick', function() {
    //     this.setMap(null);
    // });
}


$(document).ready(function(){
   $(document).on('click', '#novoLugar', function (e) {

       /*nome         = $('#nomeNovoLugar').val();
       categoria    = $('input:checkbox:checked').map(function () { return this.value; }).get();
       descricao    = $('#descNovoLugar').val();
       ponto        = latitude + ", " + longitude;

       data = jQuery.param({ nome: nome, categoria : categoria, descricao: descricao, ponto: ponto})+"&acao=cadastrar";*/
       var formData = new FormData($('#formAddNovoLugar')[0]);
       ponto        = latitude + ", " + longitude;
       formData.append("ponto", ponto);
       console.log(formData.entries());
       $.ajax({
           type: "POST",
           url: "../../controller/ControllerLocal.php",
           data: formData,
           contentType: false,
           processData: false,
           success: function(result){
               console.log(result);
           },
           error: function (xhr, ajaxOptions, thrownError) {
               console.log(xhr.status);
               console.log(thrownError);
           }
       });
       addPlace();
       infowindow.close();
       newMarker.setMap(map);
       //google.maps.event.trigger(map, 'resize');
       //try {google;} catch (e){location.reload();}

   });



   $(document).on('click', '#btnNaoAdd', function () {
       infowindow.close();
       //$("#divAdd").hide();
   });
});
