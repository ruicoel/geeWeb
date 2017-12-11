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

    var icons = {
        localAtivo: {
            name: "Local Ativo",
            path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
            strokeColor: '#f5f5ff',
            fillColor: '#38d8ff',
            fillOpacity: 1
        },

        localInativo: {
            name: "Local Inativo",
            path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
            strokeColor: '#f5f5ff',
            fillColor: '#ff6e87',
            fillOpacity: 1
        },
        posicaoAtual : {
            name: "Posição Atual",
            url: 'https://cdn.iconscout.com/public/images/icon/premium/png-512/handsup-person-with-hands-up-raised-spectator-exercising-37d1cb8ce1925362-512x512.png',
            scaledSize : new google.maps.Size(32, 42),
        }
    };

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
                icon: icons.posicaoAtual,
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
            downloadUrl('../../dao/xmlAdm.php', function(data) {
                var xml = data.responseXML;
                markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {

                    var name    = markerElem.getAttribute('nome');
                    var id      = markerElem.getAttribute('id');
                    var address = markerElem.getAttribute('descricao');

                    //var type = markerElem.getAttribute('type');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('lat')),
                        parseFloat(markerElem.getAttribute('lng')));

                    var infowincontent  = document.createElement('div');
                    var strong          = document.createElement('strong');
                    strong.textContent  = name;

                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));

                    var text            = document.createElement('text');
                    text.textContent    = address
                    infowincontent.appendChild(text);

                    var imagem          = document.createElement("img");
                    infowincontent.appendChild(imagem);
                    var content22 = '<div id="iw-container">';
                    content22.concat('<div class="iw-title">'+markerElem.getAttribute('nome')+'</div>');
                    content22.concat('<div class="iw-content">');
                    //content22.concat('<img src="'+markerElem.getAttribute('imagem')+'" alt="'+markerElem.getAttribute('nome')+'" height="115" width="83">');
                    content22.concat('<div class="iw-subTitle">Descrição</div>');
                    content22.concat('<p>'+markerElem.getAttribute('descricao')+'</p>');
                    content22.concat('</div>');
                    content22.concat('<div class="iw-bottom-gradient"></div>');
                    content22.concat('</div>');

                    // var contentString = '<div class="info-window">' +
                    //     '<h2>'+markerElem.getAttribute('nome')+'</h2>' +
                    //     '<div class="info-content">' +
                    //     '<p>'+markerElem.getAttribute('descricao')+'</p>';
                    // if(markerElem.getAttribute('privado') == 0){
                    //     contentString+= '<p><button type="button" class="btn btn-success btn-xs"> Público </button></p>';
                    // }else {
                    //     contentString+=  '<p><button type="button" class="btn btn-warning btn-xs"> Privado </button></p>';
                    // }
                    // contentString+=    '</div></div>';
                    var contentString = '<div class="info-window">' +
                        '<h2>'+markerElem.getAttribute('nome')+'</h2>' +
                        '<div class="info-content">';
                        contentString+= '<p><button style="width: 100%"; type="button" class="btn btn-primary btn-xl detalhes" data-id="'+id+'"> Detalhes </button></p>';
                        contentString+=    '</div></div>';

                    if(markerElem.getAttribute('ativo') == 1){
                        newMarker = new google.maps.Marker({
                            map: map,
                            position: point,
                            icon: icons.localAtivo

                        });
                    } else {
                        newMarker = new google.maps.Marker({
                            map: map,
                            position: point,
                            icon: icons.localInativo
                            //label: icon.label
                        });
                    }

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

    var legend = document.getElementById('legend');
    for (var key in icons) {
        var type    = icons[key];
        var name    = type.name;
        var div     = document.createElement('div');
        var aux;
        name == "Posição Atual" ? aux = 1 : (name != "Local Ativo" ? aux = 2 : aux = 0);
        var icon = name != "Posição Atual" ? type.path : type.url;

        if      (aux == 0)  div.innerHTML = '</br><svg baseProfile="basic" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g stroke="white" fill="#38d8ff"><path  d="M24 0c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z"></path></g></svg> '+ name;
        else if (aux == 2)  div.innerHTML = '</br><svg baseProfile="basic" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g stroke="white" fill="#ff6e87"><path  d="M24 0c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z"></path></g></svg> '+ name;
        else if (aux == 1)  div.innerHTML = '</br><img style="width: 48px; height: 48px" src="' + icon + '"> ' + name;

        legend.appendChild(div);
    }

    map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);
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
}


$(document).ready(function(){
   /*$(document).on('click', '#novoLugar', function (e) {

       ponto        = latitude + ", " + longitude;
       var data = $('#formAddNovoLugar').serialize();
       data += '&ponto='+ponto;
       var formData = new FormData($('#formAddNovoLugar')[0]);
       formData.append("ponto", ponto);
       console.log(formData.getAll("arquivo"));
       $.ajax({
           type: "POST",
           url: "../../controller/ControllerLocal.php",
           data: formData,
           contentType: false,
           processData: false,
           success: function(result){
               /!*console.log(result);*!/
               $.notify({
                   title: '<strong>Local inserido com sucesso!</strong>',
                   message: 'Aguarde a autorização para que seja possível encontrá-lo'
               },{
                   delay: 3000,
                   type: "success",
                   placement:{
                       from: "top",
                       align: "left"
                   }
               });
           },
           error: function (xhr, ajaxOptions, thrownError) {
               console.log(xhr.status);
               console.log(thrownError);
           }
       });
       addPlace();
       infowindow.close();
       newMarker.setMap(map);
   });*/



   $(document).on('click', '#btnNaoAdd', function () {
       infowindow.close();
   });
   //Aqui no on click do botao de detalhes
   $(document).on('click', '#detalhes', function () {
       console.log("clicado");
   });
});
function categoriasCheckbox() {
    setTimeout(function () {
        $('.button-checkbox').each(function () {
            // Settings
            var $widget = $(this),
                $button = $widget.find('button'),
                $checkbox = $widget.find('input:checkbox'),
                color = $button.data('color'),
                settings = {
                    on: {
                        icon: 'glyphicon glyphicon-check'
                    },
                    off: {
                        icon: 'glyphicon glyphicon-unchecked'
                    }
                };

            // Event Handlers
            $button.on('click', function () {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
                $checkbox.triggerHandler('change');
                updateDisplay();
            });
            $checkbox.on('change', function () {
                updateDisplay();
            });

            // Actions
            function updateDisplay() {
                var isChecked = $checkbox.is(':checked');

                // Set the button's state
                $button.data('state', (isChecked) ? "on" : "off");

                // Set the button's icon
                $button.find('.state-icon')
                    .removeClass()
                    .addClass('state-icon ' + settings[$button.data('state')].icon);

                // Update the button's color
                if (isChecked) {
                    $button
                        .removeClass('btn-default')
                        .addClass('btn-' + color + ' active');
                }
                else {
                    $button
                        .removeClass('btn-' + color + ' active')
                        .addClass('btn-default');
                }
            }

            // Initialization
            function init() {

                updateDisplay();

                // Inject the icon if applicable
                if ($button.find('.state-icon').length == 0) {
                    $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                }
            }
            init();
        });
    },1000)
}