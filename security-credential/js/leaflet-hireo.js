
/* ----------------- Start Document ----------------- */
$(document).ready(function(){
if(document.getElementById("map") !== null){

	// Touch Gestures
	if ( $('#map').attr('data-map-scroll') == 'true' || $(window).width() < 992 ) {
		var scrollEnabled = false;
	} else {
		var scrollEnabled = true;
	}

	var mapOptions = {
		gestureHandling: scrollEnabled,
	}

	// Map Init
	window.map = L.map('map',mapOptions);
	$('#scrollEnabling').hide();


	// ----------------------------------------------- //
	// Popup Output
	// ----------------------------------------------- //
	function locationData(jobURL, companyLogo, companyName, jobTitle, verifiedBadge) {
	  return(''+
	    '<a href="'+jobURL+'" class="job-listing">'+
	       '<div class="job-listing-details">'+
	          '<div class="job-listing-company-logo">'+
	            '<div class="'+verifiedBadge+'-badge"></div>'+
	            '<img src="'+companyLogo+'" alt="">'+
	          '</div>'+
	          '<div class="job-listing-description">'+
	            '<h4 class="job-listing-company">'+companyName+'</h4>'+
	            '<h3 class="job-listing-title">'+jobTitle+'</h3>'+
	          '</div>'+
	       '</div>'+
	    '</a>')
	}

	// ----------------------------------------------- //
	// Locations
	// ----------------------------------------------- //
	var locations = [
		[ locationData('single-job-page.html','images/company-logo-01.png',"Hexagon",'Bilingual Event Support Specialist', 'verified'), 37.788181, -122.461270, 5, ''],
		[ locationData('single-job-page.html','images/company-logo-05.png',"Laxo",'Competition Law Officer', 'not-verified'), 37.750812, -122.471934, 2, ''],
		[ locationData('single-job-page.html','images/company-logo-02.png',"Coffee",'Barista and Cashier', 'not-verified'), 37.735609, -122.458201, 3, ''],
		[ locationData('single-job-page.html','images/company-logo-03.png',"King",'Restaurant General Manager', 'verified'), 37.745382, -122.500773, 4, ''],
		[ locationData('single-job-page.html','images/company-logo-05.png',"Skyist",'International Marketing Coordinator', 'not-verified'), 37.762963, -122.388506, 1, ''],
		[ locationData('single-job-page.html','images/company-logo-05.png',"Podous",'Construction Labourers', 'not-verified'), 37.801745, -122.409085, 6, ''],
		[ locationData('single-job-page.html','images/company-logo-04.png',"Mates",'Administrative Assistant', 'not-verified'), 37.730511, -122.383679, 7, ''],
		[ locationData('single-job-page.html','images/company-logo-06.png',"Trideo",'Human Resources Consultant', 'not-verified'), 37.750457, -122.478779, 8, ''],
		[ locationData('single-job-page.html','images/company-logo-06.png',"Trideo",'International Marketing Specialist', 'not-verified'), 37.732810, -122.415951, 9, ''],
		[ locationData('single-job-page.html','images/company-logo-02.png',"Coffee",'Terrain Cafe Barista', 'not-verified'), 37.733625, -122.378872, 10, ''],
		[ locationData('#','images/company-logo-05.png',"Kinte",'Skilled Labourer', 'not-verified'), 37.723578, -122.457493, 11, ''],
		[ locationData('single-job-page.html','images/company-logo-05.png',"Alilia",'Healthcare Claims Advisor', 'not-verified'), 37.751543, -122.418354, 12, ''],
	];


	// ----------------------------------------------- //
	// Map Provider
	// ----------------------------------------------- //

	// Open Street Map 
	// -----------------------//
	L.tileLayer(
		'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> Contributors',
		maxZoom: 18,
	}).addTo(map);


	// MapBox (Requires API Key)
	// -----------------------//
	// L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}@2x.png?access_token={accessToken}', {
	//     attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a>",
	//     maxZoom: 18,
	//     id: 'mapbox.streets',
	//     accessToken: 'pk.eyJ1IjoiZXllNjY0IiwiYSI6ImNrZWlrYXI0azFrcTkycm43MTNjMjF5dngifQ.bYnjCzvUThvXJm1RWEuEyQ'
	// }).addTo(map);


	// ThunderForest (Requires API Key)
	// -----------------------//
	// var ThunderForest_API_Key = 'API_KEY';
	// var tileUrl = 'https://tile.thunderforest.com/neighbourhood/{z}/{x}/{y}.png?apikey='+ThunderForest_API_Key,
	// layer = new L.TileLayer(tileUrl, {maxZoom: 18});
	// map.addLayer(layer);


	// ----------------------------------------------- //
	// Markers
	// ----------------------------------------------- //
        markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
          });
       
        for (var i = 0; i < locations.length; i++) {

          var hireoIcon = L.divIcon({
              iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
              popupAnchor: [0, 0],
              className: 'hireo-marker-icon',
              html:  '<div class="marker-container">'+
                       '<div class="marker-card">'+
                          '<div class="front face">' + locations[i][4] + '</div>'+
                          '<div class="back face">' + locations[i][4] + '</div>'+
                          '<div class="marker-arrow"></div>'+
                       '</div>'+
                     '</div>'
            }
          );

            var popupOptions =
              {
              'maxWidth': '320',
              'minWidth': '320',
              'className' : 'leaflet-infoBox'
              }
                var markerArray = [];
            marker = new L.marker([locations[i][1],locations[i][2]], {
                icon: hireoIcon,
                
              })
              .bindPopup(locations[i][0],popupOptions );
              //.addTo(map);
              marker.on('click', function(e){
                
               // L.DomUtil.addClass(marker._icon, 'clicked');
              });
              map.on('popupopen', function (e) {
                L.DomUtil.addClass(e.popup._source._icon, 'clicked');
            

              }).on('popupclose', function (e) {
                if(e.popup){
                  L.DomUtil.removeClass(e.popup._source._icon, 'clicked');  
                }
                
              });
              markers.addLayer(marker);
        }
        map.addLayer(markers);

    
        markerArray.push(markers);
        if(markerArray.length > 0 ){
          map.fitBounds(L.featureGroup(markerArray).getBounds().pad(0.2)); 
        }


	// Custom Zoom Control
	map.removeControl(map.zoomControl);

	var zoomOptions = {
		zoomInText: '',
		zoomOutText: '',
	};

	// Creating zoom control
	var zoom = L.control.zoom(zoomOptions);
	zoom.addTo(map);

}


// ----------------------------------------------- //
// Single Listing Map
// ----------------------------------------------- //
function singleListingMap() {

	var lng = parseFloat($( '#singleListingMap' ).data('longitude'));
	var lat =  parseFloat($( '#singleListingMap' ).data('latitude'));
	var singleMapIco =  "<i class='"+$('#singleListingMap').data('map-icon')+"'></i>";

	var hireoIcon = L.divIcon({
	    iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
	    popupAnchor: [0, 0],
	    className: 'hireo-marker-icon',
	    html:  '<div class="marker-container no-marker-icon ">'+
	                     '<div class="marker-card">'+
	                        '<div class="front face">' + singleMapIco + '</div>'+
	                        '<div class="back face">' + singleMapIco + '</div>'+
	                        '<div class="marker-arrow"></div>'+
	                     '</div>'+
	                   '</div>'
	    
	  }
	);

	var mapOptions = {
	    center: [lat,lng],
	    zoom: 13,
	    zoomControl: false,
	    gestureHandling: true
	}

	var map_single = L.map('singleListingMap',mapOptions);
	var zoomOptions = {
	   zoomInText: '<i class="fa fa-plus" aria-hidden="true"></i>',
	   zoomOutText: '<i class="fa fa-minus" aria-hidden="true"></i>',
	};

	// Zoom Control
	var zoom = L.control.zoom(zoomOptions);
	zoom.addTo(map_single);

	map_single.scrollWheelZoom.disable();

	marker = new L.marker([lat,lng], {
	      icon: hireoIcon,
	}).addTo(map_single);

	// Open Street Map 
	// -----------------------//
	// L.tileLayer(
	// 	'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	// 	attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> Contributors',
	// 	maxZoom: 18,
	// }).addTo(map_single);


	// MapBox (Requires API Key)
	// -----------------------//
	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}@2x.png?access_token={accessToken}', {
	    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a>",
	    maxZoom: 18,
	    id: 'mapbox.streets',
	    accessToken: 'pk.eyJ1IjoidmFzdGVyYWQiLCJhIjoiY2p5cjd0NTc1MDdwaDNtbnVoOGwzNmo4aSJ9.BnYb645YABOY2G4yWAFRVw'
	}).addTo(map_single);
	

	// Street View Button URL
	$('a#streetView').attr({
		href: 'https://www.google.com/maps/search/?api=1&query='+lat+','+lng+'',
		target: '_blank'
	});
}

// Single Listing Map Init
if(document.getElementById("singleListingMap") !== null){
	singleListingMap();
}


});