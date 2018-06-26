<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="style.css">
  <title> Vibration Detector </title>
  <link rel="icon" href="sa.png">
  </head>
  <body>
  <div class="container">
          <div class="range">
            <div class="slidecontainer">
               <input type="range" min="8"  step="0.111111" max="40" value="9" class="slider" id="myRange">
               <span id="demo"></span>
             </div>
          </div>
          <div id="map"></div>
          </div>
    <script>

        
      var map;
      var json;
      var markers = [];
      function addMarker(location) {
        var icon = {
            url: "sa.png", // url
            scaledSize: new google.maps.Size(30, 30 ), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(0, 0) // anchor
        };
        var marker = new google.maps.Marker({
          position: location,
          map: map,
          icon:icon

        });
        markers.push(marker);
      }
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }
      function clearMarkers() {
        setMapOnAll(null);
      }
      function showMarkers() {
        setMapOnAll(map);
      }

      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      function getdata(max){
        deleteMarkers();
        $.get("http://localhost/heroku_test/event.php?act=map&max="+max, function(data, status){
            for (var i = 0, length = data.length; i < length; i++) {
              var dt = data[i];
              // console.log(dt.id + " " +dt.latitude);
              latLng = new google.maps.LatLng(dt.latitude, dt.longitude);

              addMarker(latLng);
              // var marker = new google.maps.Marker({
              //   position: latLng,
              //   map: map,
              //   title: dt.vib
              // }); 
              // var infoWindow = new google.maps.InfoWindow();
              // google.maps.event.addListener(marker, "click", function(e) {
              //   infoWindow.setContent(dt.vib);
              //   infoWindow.open(map, marker);
              // });
            }
          
         });
      }
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: new google.maps.LatLng(31.6347485,-8.0778939),
          mapTypeId: 'roadmap'
        });
        getdata(9);
     
      
      }
      var slider = document.getElementById("myRange");
      var output = document.getElementById("demo");
      output.innerHTML = slider.value;

      slider.oninput = function() {
        output.innerHTML = this.value;
        getdata(this.value);
      }
    </script>

    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB50YJrGSNWhrQxtUZuFUZSO0Pu3BXe7IU&callback=initMap">
    </script>

<script>


</script>
<!--  -->
  </body>
</html>
