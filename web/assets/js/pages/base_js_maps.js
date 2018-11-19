/*
Document: base_js_maps.js
Author: Rustheme
Description: Custom JS code used in Maps Page
 */

var map;
var contents = new Array();
var markers = new Array();
var infowindow;
var directionsDisplay, directionsService;
var pret = false;

var BaseJsMaps = function() {

	// Init Markers Map
	var initMapMarkers = function() {
        detectBrowser();
        directionsDisplay = new google.maps.DirectionsRenderer();
        directionsService = new google.maps.DirectionsService();
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 3.854642, lng: 11.486378},
            zoom: 7
        });
        directionsDisplay.setMap(map);

        var adresse = document.getElementById("pathmapall").value;
        infowindow = new google.maps.InfoWindow();

        $.getJSON(adresse, function (data) {
            var nb = data.length;
            for (var i = 0; i < nb; i++) {
                var text = '<div class="card" style="margin: 5px; clear: both;">' +
                                '<h4>Détails de l\'observation</h4>' +
                                '<img style="margin: 10px" width="120" height="80" src="' + imageChemin + data[i]["image"] +'" />'+
                                '<ul class="list" style="font-size:12px; float: left;">' +
                                    '<li><b>N°:</b> ' + data[i]["alpha"] + '</li>'+
                                    '<li><b>Date:</b> ' + data[i]["date"] + ' à ' + data[i]["heure"] + '</li>' +
                                    '<li><b>Type:</b> ' + data[i]["type"] + '</li>'+
                                    '<li><b>Espece:</b> ' + data[i]["espece"] + '</li>'+
                                    '<li><b>Groupe:</b> ' + data[i]["groupe"] + '</li>'+
                                    '<li><b>Sous-groupe:</b> ' + data[i]["sousgroupe"] + '</li>'+
                                    '<li><b>Auteur:</b> ' + data[i]["userAdd"] + '</li>'+
                                '</ul>' +
                            '</div>';
                contents[i] = text;
                var image;
                switch (data[i]["typeid"]) {
                    case 1:
                        if(data[i]["mort"] == 0)
                            image = catvivant;
                        else
                            image = catmort;
                        break;
                    case 2:
                        image = cat2;
                        break;
                    case 3:
                        image = cat3;
                        break;
                    case 4:
                        image = cat4;
                        break;
                    default:
                        image = defaut;
                        break;
                }

                markers[i] = new google.maps.Marker({
                    position: {lat: data[i]["coordX"], lng: data[i]["coordY"]},
                    map: map,
                    label: {text: data[i]["alpha"]+"", color: "white", fontSize: "12px"},
                    icon: image,
                    title: data[i]["userAdd"]
                });

                markers[i].addListener('click', function () {
                    for (var x = 0; x < markers.length; x++) {
                        if (markers[x] == this) {
                            break;
                        }
                    }
                    infowindow.setContent(contents[x]);
                    infowindow.open(map, markers[x]);
                });

            }

            map.addListener('click', function () {
                infowindow.close();
            })
        });
	};

    var detectBrowser = function() {
        var useragent = navigator.userAgent;
        var mapdiv = document.getElementById("map");

        if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1) {
            mapdiv.style.width = '100%';
            mapdiv.style.height = '300px';
        } else {
            $(mapdiv).css('width', '100%');
            mapdiv.style.height = '700px';
        }
    };

    var selectMarkers = function() {
        /*$("#modalWaith").modal({dismissible: false});
        $("#modalWaith").modal("open");

        $("#modalWaith").css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)");
        $("#modalWaith").css("filter", "alpha(opacity=50)");
        $("#modalWaith").css("-moz-opacity", "0.5");
        $("#modalWaith").css("-khtml-opacity", "0.5");
        $("#modalWaith").css("opacity", "0.5");*/
        
        //var type = $("input[name='type']:checked").val();
        var menace = $("#menace").is(":checked");
        var presence = $("#presence").is(":checked");
        var vivant = $("#vivant").is(":checked");
        var mort = $("#mort").is(":checked");
        var alimentation = $("#alimentation").is(":checked");

        var debut = $("#datedebut").val();
        var fin = $("#datefin").val();
        
        
        var pathmarker = document.getElementById("pathmarker").value;
        alert("pathmarker");
        var data = {
            menace: menace,
            presence: presence,
            alimentation: alimentation,
            vivant: vivant,
            mort: mort,
            debut: debut,
            fin: fin
        };
        $.ajax({
            url: pathmarker,
            type: "POST",
            dataType: 'json', // selon le retour attendu
            data: data,
            success: function (donnees) {
                 alert(nbeobservation +markers.length);
                // La réponse du serveur
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];

                var nb = donnees.length;
                var html;
                for (var i = 0; i < nb; i++) {

                  html = '<div class="card" style="margin: 5px; clear: both;">' +
                            '<h4>'+ labeltitre + '</h4>' +
                            '<img style="margin: 10px" width="120" height="80" src="' + imageChemin + donnees[i]["image"] +'" />'+
                            '<ul class="list" style="font-size:12px; float: left;">' +
                                '<li><b>N°:</b> ' + donnees[i]["alpha"] + '</li>'+
                                '<li><b>Date:</b> ' + donnees[i]["date"] + ' à ' + donnees[i]["heure"] + '</li>' +
                                '<li><b>Type:</b> ' + donnees[i]["type"] + '</li>'+
                                '<li><b>Espece:</b> ' + donnees[i]["espece"] + '</li>'+
                                '<li><b>Groupe:</b> ' + donnees[i]["groupe"] + '</li>'+
                                '<li><b>Sous-groupe:</b> ' + donnees[i]["sousgroupe"] + '</li>'+
                                '<li><b>Auteur:</b> ' + donnees[i]["userAdd"] + '</li>'+
                            '</ul>' +
                        '</div>';
                    contents[i] = html;

                    var image;
                    switch (donnees[i]["typeid"]) {
                        case 1:
                            if(donnees[i]["mort"] == 0)
                                image = catvivant;
                            else
                                image = catmort;
                            break;
                        case 2:
                            image = cat2;
                            break;
                        case 3:
                            image = cat3;
                            break;
                        case 4:
                            image = cat4;
                            break;
                        default:
                            image = defaut;
                            break;
                    }
                    markers[i] = new google.maps.Marker({
                        position: {lat: donnees[i]["coordX"], lng: donnees[i]["coordY"]},
                        map: map,
                        label: {text: donnees[i]["alpha"]+"", color: "white"},
                        icon: image,
                        title: donnees[i]["userAdd"]
                    });

                    markers[i].addListener('click', function () {
                        for (var x = 0; x < markers.length; x++) {
                            if (markers[x] == this) {
                                break;
                            }
                        }
                        infowindow.setContent(contents[x]);
                        infowindow.open(map, markers[x]);
                    });

                }

                //$("#modalWaith").modal("close");
            }
        });
    };


	return {
		init: function () {
			// Gmaps.js: https://hpneo.github.io/gmaps/

			initMapMarkers();

			var btMap = document.getElementById("generer");

			btMap.addEventListener("click", selectMarkers, false);
		}
	};
}();

// Initialize when page loads
jQuery( function() {
	//BaseJsMaps.init();
});
