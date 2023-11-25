<?php
$lat = $_GET["lat"];
$long = $_GET["long"];
$url =
  "https://maps.googleapis.com/maps/api/geocode/json?latlng=" .
  $lat .
  "," .
  $long .
  "&key=AIzaSyA6Q2KhNst9ZYjXMJi7T4oAqAjvqdeVhGc";
$response = file_get_contents($url);
$json = json_decode($response, true);
$address = $json["results"][0]["formatted_address"];
echo "Your current location is: " . $address;
?>
