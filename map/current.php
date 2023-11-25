<!DOCTYPE html>
<html>
  <head>
    <title>Current Location</title>
    <meta charset="UTF-8" />
    <script>
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6Q2KhNst9ZYjXMJi7T4oAqAjvqdeVhGc"
    defer
    </script>
    <script> 
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else {
          alert("Geolocation is not supported by this browser.");
        }
      }

      function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        var url =
          "current_location.php?lat=" + latitude + "&long=" + longitude;
        window.location = url;
      }
    </script>
  </head>
  <body onload="getLocation()">
    <p>Please wait while we locate you...</p>
  </body>
</html>
