<?php
$page_title = "Startsida";
include("includes/header.php");
?>

<div id="container2" >
    <h3> Karta över huvudkontor till organisationer eller grupper som arbetar för jämnställdhet </h3>
</div>
<div id="map"></div>

<script> 
    function initMap(){ //funktion som sätter startpsoition när man kommer till sidan 
        var options = {
            zoom:6,
            center:{lat: 59.31299,lng:18.10136}
        }

        var map = new google.maps.Map(document.getElementById('map'), options); //kartan skapas

        
        var markers = [ //arrayer på alla koordinater och dess hemsidor och namn
            {
                coordinates: {lat: 57.79721,lng:12.05250},
                content: '<a href="https://jamstalldhetsmyndigheten.se/swedish-gender-equality-agency/"> Jämnställdhetsmyndigheten</a>'
            },
            {
                coordinates: {lat: 59.29319,lng:18.07553}, 
                content: '<a href="https://kvinnatillkvinna.se/"> Kvinna till kvinna </a>'
            },
            {
                coordinates: {lat: 59.34596,lng:18.04754},
                content: '<a href="https://ikff.se/"> Internationella Kvinnoförbundet för Fred och Frihet </a>'
            },
            {
                coordinates: {lat: 59.31299,lng:18.10136},
                content: '<a href="https://globalportalen.org/"> Globalportalen </a>'
            },
            {
                coordinates: {lat: 59.32847,lng:17.98394},
                content: '<a href="https://www.studieframjandet.se/"> Studiefrämjandet </a>'
            },
            {
                coordinates: {lat: 59.35866,lng:17.98057},
                content: '<a href=" https://www.skolverket.se/skolutveckling/leda-och-organisera-skolan/leda-personal/leda-jamstalldhetsarbete"> Skolverket </a>'
            }
        ];

        //for-loop som går igenom markers
        for(var i = 0;i < markers.length;i++){ //så länge i är mindre än markers längd, öka med 1
        addMarker(markers[i]); //skickar in markers[i] i funktionen addMarker
        }


        function addMarker(props){ //skapar markeringar på kartan
            var marker = new google.maps.Marker({ //google maps marker-metoder används
                position:props.coordinates, //coordinates tas ut med hjälp av props 
                map:map //variabeln map 
        });

            if(props.content){ //skapar textrutor på markeringarna
                var infoWindow = new google.maps.InfoWindow({
                content:props.content
        })}
        
            marker.addListener('click', function(){ //vid klick på markering kommer textruta upp
            infoWindow.open(map, marker);
        });
        }
    }


</script>

<!-- defer attribute säger åt browser att inte vänta på scrpitet utan fortsätter att processas HTML och skapar DOM -->
<!--async gör scrpit nonblocking m.m -->

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd2zWs2fLR2hDrUVQCwIAuVGmyjlv0erE&callback=initMap">
</script>

</body>
</html>