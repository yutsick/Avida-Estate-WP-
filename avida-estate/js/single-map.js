(function($) {
    "use strict";

    var map;
    var styles;
    var marker                = [];
    var placesIDs             = [];
    var schoolsMarkers        = [];
    var transportationMarkers = [];
    var restaurantsMarkers    = [];
    var shoppingMarkers       = [];
    var cafesMarkers          = [];
    var artsMarkers           = [];
    var fitnessMarkers        = [];

    // Property map marker position
    var propLat = $('#lat').val();
    var propLng = $('#lng').val();

    var options = {
        zoom : 14,
        mapTypeId : 'Styled',
        panControl: false,
        zoomControl: true,
        mapTypeControl: !$('#pxp-sp-map').hasClass('is-d4-layout'),
        scaleControl: false,
        streetViewControl: true,
        overviewMapControl: false,
        scrollwheel: false,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM,
        },
        fullscreenControl: true,
    };

    if (map_single_vars.gmaps_style != '') {
        styles = jQuery.parseJSON(decodeURIComponent(map_single_vars.gmaps_style));
    }

    var schoolsMarkerImage = {
        url: services_vars.theme_url + '/images/schools-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };
    var transportationMarkerImage = {
        url: services_vars.theme_url + '/images/transportation-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };
    var restaurantsMarkerImage = {
        url: services_vars.theme_url + '/images/restaurants-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };
    var shoppingMarkerImage = {
        url: services_vars.theme_url + '/images/shopping-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };
    var cafesMarkerImage = {
        url: services_vars.theme_url + '/images/cafes-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };
    var artsMarkerImage = {
        url: services_vars.theme_url + '/images/arts-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };
    var fitnessMarkerImage = {
        url: services_vars.theme_url + '/images/fitness-marker.png',
        size: new google.maps.Size(47, 47),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 21),
        scaledSize: { width: 47, height: 47 }
    };

    var info = new InfoBox({
        disableAutoPan: false,
        maxWidth: 200,
        pixelOffset: new google.maps.Size(-70, -44),
        zIndex: null,
        boxClass: 'poi-box',
        boxStyle: {
            'background' : '#fff',
            'opacity'    : 1,
            'padding'    : '5px',
            'box-shadow' : '0 1px 2px 0 rgba(0, 0, 0, 0.13)',
            'width'      : '140px',
            'text-align' : 'center',
            'border-radius' : '3px'
        },
        closeBoxMargin: "28px 26px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        pane: "floatPane",
        enableEventPropagation: false
    });

    function getPOIs(pos, map, type) {
        var service   = new google.maps.places.PlacesService(map);
        var bounds    = map.getBounds();
        var types     = new Array();

        switch(type) {
            case 'schools':
                types = ['school', 'primary_school', 'secondary_school', 'university'];
                break;
            case 'transportation':
                types = ['bus_station', 'subway_station', 'train_station', 'transit_station', 'airport'];
                break;
            case 'restaurants':
                types = ['restaurant'];
                break;
            case 'shopping':
                types = ['bicycle_store', 'book_store', 'clothing_store', 'convenience_store', 'department_store', 'electronics_store', 'florist', 'furniture_store', 'hardware_store', 'home_goods_store', 'jewelry_store', 'liquor_store', 'shoe_store', 'shopping_mall', 'store', 'supermarket'];
                break;
            case 'cafes':
                types = ['bar', 'cafe'];
                break;
            case 'arts':
                types = ['amusement_park', 'aquarium', 'art_gallery', 'bowling_alley', 'casino', 'movie_rental', 'movie_theater', 'museum', 'stadium', 'zoo'];
                break;
            case 'fitness':
                types = ['gym'];
                break;
        }

        $.each(types, function(i, t) {
            service.nearbySearch({
                location: pos,
                bounds: bounds,
                radius: 2000,
                types: [t]
            }, function poiCallback(results, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {
                        if (jQuery.inArray(results[i].place_id, placesIDs) == -1) {
                            createPOI(results[i], map, type);
                            placesIDs.push(results[i].place_id);
                        }
                    }
                }
            });
        });
    }

    function createPOI(place, map, type) {
        var placeLoc = place.geometry.location;
        var poiMarker;

        switch (type) {
            case 'schools':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: schoolsMarkerImage,
                });
                schoolsMarkers.push(poiMarker);
                break;
            case 'transportation':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: transportationMarkerImage,
                });
                transportationMarkers.push(poiMarker);
                break;
            case 'restaurants':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: restaurantsMarkerImage,
                });
                restaurantsMarkers.push(poiMarker);
                break;
            case 'shopping':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: shoppingMarkerImage,
                });
                shoppingMarkers.push(poiMarker);
                break;
            case 'cafes':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: cafesMarkerImage,
                });
                cafesMarkers.push(poiMarker);
                break;
            case 'arts':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: artsMarkerImage,
                });
                artsMarkers.push(poiMarker);
                break;
            case 'fitness':
                poiMarker = new google.maps.Marker({
                    map: map,
                    position: placeLoc,
                    icon: fitnessMarkerImage,
                });
                fitnessMarkers.push(poiMarker);
                break;
        }

        google.maps.event.addListener(poiMarker, 'mouseover', function() {
            info.setContent(place.name);
            info.open(map, this);
        });
        google.maps.event.addListener(poiMarker, 'mouseout', function() {
            info.open(null,null);
        });
    }

    function tooglePOIs(map, type) {
        for (var i = 0; i < type.length; i++) {
            if (type[i].getMap() != null) {
                type[i].setMap(null);
            } else {
                type[i].setMap(map);
            }
        }
    }

    function PoiControls(controlDiv, pmap, center) {
        controlDiv.style.clear = 'both';

        if (map_vars.poi_schools == '1') {
            // Set CSS for schools POI
            var schoolsUI = document.createElement('div');
            schoolsUI.id = 'schoolsUI';
            schoolsUI.title = map_vars.schools_title;
            controlDiv.appendChild(schoolsUI);
            var schoolsIcon = document.createElement('div');
            schoolsIcon.id = 'schoolsIcon';
            schoolsIcon.innerHTML = '<span class="fa fa-university"></span>';
            schoolsUI.appendChild(schoolsIcon);

            schoolsUI.addEventListener('click', function() {
                var schoolsUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, schoolsMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'schools');
                    tooglePOIs(pmap, schoolsMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(schoolsUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'schools');
                    }
                });
            });
        }

        if (map_vars.poi_transportation == '1') {
            // Set CSS for transportation POI
            var transportationUI = document.createElement('div');
            transportationUI.id = 'transportationUI';
            transportationUI.title = map_vars.transportation_title;
            controlDiv.appendChild(transportationUI);
            var transportationIcon = document.createElement('div');
            transportationIcon.id = 'transportationIcon';
            transportationIcon.innerHTML = '<span class="fa fa-subway"></span>';
            transportationUI.appendChild(transportationIcon);

            transportationUI.addEventListener('click', function() {
                var transportationUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, transportationMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'transportation');
                    tooglePOIs(pmap, transportationMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(transportationUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'transportation');
                    }
                });
            });
        }

        if (map_vars.poi_restaurants == '1') {
            // Set CSS for restaurants POI
            var restaurantsUI = document.createElement('div');
            restaurantsUI.id = 'restaurantsUI';
            restaurantsUI.title = map_vars.restaurants_title;
            controlDiv.appendChild(restaurantsUI);
            var restaurantsIcon = document.createElement('div');
            restaurantsIcon.id = 'restaurantsIcon';
            restaurantsIcon.innerHTML = '<span class="fa fa-cutlery"></span>';
            restaurantsUI.appendChild(restaurantsIcon);

            restaurantsUI.addEventListener('click', function() {
                var restaurantsUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, restaurantsMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'restaurants');
                    tooglePOIs(pmap, restaurantsMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(restaurantsUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'restaurants');
                    }
                });
            });
        }

        if (map_vars.poi_shopping == '1') {
            // Set CSS for shopping POI
            var shoppingUI = document.createElement('div');
            shoppingUI.id = 'shoppingUI';
            shoppingUI.title = map_vars.shopping_title;
            controlDiv.appendChild(shoppingUI);
            var shoppingIcon = document.createElement('div');
            shoppingIcon.id = 'shoppingIcon';
            shoppingIcon.innerHTML = '<span class="fa fa-shopping-basket"></span>';
            shoppingUI.appendChild(shoppingIcon);

            shoppingUI.addEventListener('click', function() {
                var shoppingUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, shoppingMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'shopping');
                    tooglePOIs(pmap, shoppingMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(shoppingUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'shopping');
                    }
                });
            });
        }

        if (map_vars.poi_cafes == '1') {
            // Set CSS for cafes & bars POI
            var cafesUI = document.createElement('div');
            cafesUI.id = 'cafesUI';
            cafesUI.title = map_vars.cafes_title;
            controlDiv.appendChild(cafesUI);
            var cafesIcon = document.createElement('div');
            cafesIcon.id = 'cafesIcon';
            cafesIcon.innerHTML = '<span class="fa fa-coffee"></span>';
            cafesUI.appendChild(cafesIcon);

            cafesUI.addEventListener('click', function() {
                var cafesUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, cafesMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'cafes');
                    tooglePOIs(pmap, cafesMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(cafesUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'cafes');
                    }
                });
            });
        }

        if (map_vars.poi_arts == '1') {
            // Set CSS for arts & entertainment POI
            var artsUI = document.createElement('div');
            artsUI.id = 'artsUI';
            artsUI.title = map_vars.arts_title;
            controlDiv.appendChild(artsUI);
            var artsIcon = document.createElement('div');
            artsIcon.id = 'artsIcon';
            artsIcon.innerHTML = '<span class="fa fa-ticket"></span>';
            artsUI.appendChild(artsIcon);

            artsUI.addEventListener('click', function() {
                var artsUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, artsMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'arts');
                    tooglePOIs(pmap, artsMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(artsUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'arts');
                    }
                });
            });
        }

        if (map_vars.poi_fitness == '1') {
            // Set CSS for fitness POI
            var fitnessUI = document.createElement('div');
            fitnessUI.id = 'fitnessUI';
            fitnessUI.title = map_vars.fitness_title;
            controlDiv.appendChild(fitnessUI);
            var fitnessIcon = document.createElement('div');
            fitnessIcon.id = 'fitnessIcon';
            fitnessIcon.innerHTML = '<span class="fa fa-heartbeat"></span>';
            fitnessUI.appendChild(fitnessIcon);

            fitnessUI.addEventListener('click', function() {
                var fitnessUI_ = this;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
    
                    tooglePOIs(pmap, fitnessMarkers);
                } else {
                    $(this).addClass('active');
    
                    getPOIs(center, pmap, 'fitness');
                    tooglePOIs(pmap, fitnessMarkers);
                }
                google.maps.event.addListener(pmap, 'bounds_changed', function() {
                    if ($(fitnessUI_).hasClass('active')) {
                        var newCenter = pmap.getCenter();
                        getPOIs(newCenter, pmap, 'fitness');
                    }
                });
            });
        }
    }

    function setPOIControls(pmap, center) {
        var poiControlDiv = document.createElement('div');
        var poiControl = new PoiControls(poiControlDiv, pmap, center);

        poiControlDiv.index = 1;
        poiControlDiv.id = 'poiContainer';
        pmap.controls[google.maps.ControlPosition.LEFT_TOP].push(poiControlDiv);
    }

    function CustomMarker(latlng, map, classname) {
        this.latlng_   = latlng;
        this.classname = classname;

        this.setMap(map);
    }

    CustomMarker.prototype = new google.maps.OverlayView();

    CustomMarker.prototype.draw = function() {
        var me = this;
        var div = this.div_;

        if (!div) {
            div = this.div_ = document.createElement('div');
            div.classList.add(this.classname);

            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
        }

        var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);

        if (point) {
            div.style.left = point.x + 'px';
            div.style.top = point.y + 'px';
        }
    };

    function addPropMarker(propLat, propLng, map) {
        var latlng = new google.maps.LatLng(propLat, propLng);
        marker = new CustomMarker(latlng, map, 'pxp-single-marker');
    }

    setTimeout(function() {
        if($('#pxp-sp-map').length > 0) {
            map = new google.maps.Map(document.getElementById('pxp-sp-map'), options);
            var styledMapType = new google.maps.StyledMapType(styles, {
                name : 'Styled',
            });
            var center = new google.maps.LatLng(propLat, propLng);

            map.mapTypes.set('Styled', styledMapType);
            map.setCenter(center);
            map.setZoom(15);

            addPropMarker(propLat, propLng, map);

            google.maps.event.trigger(map, 'resize');

            $('.pxp-sp-pois-nav-schools').click(function() {
                var this_ = $(this);
                if($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, schoolsMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'schools');
                    tooglePOIs(map, schoolsMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if(this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'schools');
                    }
                });
            });

            $('.pxp-sp-pois-nav-transportation').click(function() {
                var this_ = $(this);
                if($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, transportationMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'transportation');
                    tooglePOIs(map, transportationMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if(this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'transportation');
                    }
                });
            });

            $('.pxp-sp-pois-nav-restaurants').click(function() {
                var this_ = $(this);
                if ($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, restaurantsMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'restaurants');
                    tooglePOIs(map, restaurantsMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if (this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'restaurants');
                    }
                });
            });

            $('.pxp-sp-pois-nav-shopping').click(function() {
                var this_ = $(this);
                if ($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, shoppingMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'shopping');
                    tooglePOIs(map, shoppingMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if(this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'shopping');
                    }
                });
            });

            $('.pxp-sp-pois-nav-cafes').click(function() {
                var this_ = $(this);
                if ($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, cafesMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'cafes');
                    tooglePOIs(map, cafesMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if (this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'cafes');
                    }
                });
            });

            $('.pxp-sp-pois-nav-arts').click(function() {
                var this_ = $(this);
                if ($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, artsMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'arts');
                    tooglePOIs(map, artsMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if (this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'arts');
                    }
                });
            });

            $('.pxp-sp-pois-nav-fitness').click(function() {
                var this_ = $(this);
                if ($(this).hasClass('pxp-active')) {
                    $(this).removeClass('pxp-active');
    
                    tooglePOIs(map, fitnessMarkers);
                } else {
                    $(this).addClass('pxp-active');
    
                    getPOIs(center, map, 'fitness');
                    tooglePOIs(map, fitnessMarkers);
                }
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    if (this_.hasClass('pxp-active')) {
                        getPOIs(map.getCenter(), map, 'fitness');
                    }
                });
            });

            if ($('#pxp-sp-map').hasClass('is-d4-layout')) {
                setPOIControls(map, map.getCenter());
            }
        }
    }, 300);
})(jQuery);