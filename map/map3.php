<?php
$apiKey = 'AIzaSyA6Q2KhNst9ZYjXMJi7T4oAqAjvqdeVhGc'; // 발급받은 API 키
$url = 'https://www.googleapis.com/geolocation/v1/geolocate?key=' . $apiKey;

$data = array('considerIp' => 'true'); // API 요청 데이터

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$result = curl_exec($ch); // API 응답 받아오기

curl_close($ch);

$response = json_decode($result, true); // JSON 데이터 파싱

$lat = $response['location']['lat']; // 현재 위치 위도
$lng = $response['location']['lng']; // 현재 위치 경도
$latitude='37.67601147989344';
$longitude='126.75184258344109';

$distance = distance($latitude, $longitude, $lat, $lng);
function distance($lat1, $lon1, $lat2, $lon2) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $km = $miles * 1.609344;
  return $km;
}
echo "현재위치: $lat $lng km";

?>
