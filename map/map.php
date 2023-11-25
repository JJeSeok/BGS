<?php
    include "../lib/dbconn.php"; 
    $num=4;
    $sql= "SELECT * FROM food where num='$num' ";
    $result= mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    $lat=$row['lat'];
    $lng=$row['lng'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnTni1Pvo8h3EDOG0LZdcxUE32b0ule9w&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
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
        margin: 20  ;
        padding: 0;
      }
    </style>
    <script>
  
      let map;
      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: 37.67606384745595, lng: 126.74730456163915 },          
          zoom: 15,
        });
      
        const myLatLng = { lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?> };
        
        new google.maps.Marker({
        position: myLatLng,
        map,
        title: "Hello World!",
    });

      }
    </script>
  </head>
  <body>
    <div id="map"></div>
  </body>
</html>