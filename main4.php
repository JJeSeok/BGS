<?php
include "./lib/dbconn.php";
$sql= "SELECT * FROM food";
$result= mysqli_query($conn,$sql);
$restaurants = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $restaurants[] = $row;
  }
}
session_start();

$lat=$_SESSION['lat'];
$lng=$_SESSION['lng'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>지도 표시 및 현재 위치 변경</title>
  <style>
    #map {
      height: 700px;
      width: 100%;
    }
  </style>
</head>
<body>
    <h1>지역 검색 맵</h1>
    <input type="text" id="search-input" placeholder="지역을 입력하세요">
    <button id="search-button">검색</button>  
    <div id="map"></div>

  <script>
    function initMap() {
      // 현재 위치 가져오기
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var currentLat = <?=$lat?>;
          var currentLng = <?=$lng?>;

          // 현재 위치를 중심으로 지도 생성
          var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: currentLat, lng: currentLng},
            zoom: 17
          });

          // 현재 위치에 마커 추가
          var marker = new google.maps.Marker({
            position: {lat: currentLat, lng: currentLng},
            map: map
          });

        var searchInput = document.getElementById('search-input');
        var searchButton = document.getElementById('search-button');
        <?php foreach ($restaurants as $restaurant): ?>
                var marker = new google.maps.Marker({
                    position: { lat: <?= $restaurant['lat'] ?>, lng: <?= $restaurant['lng'] ?> },
                    map: map,
                    title: "<?= $restaurant['name'] ?>"
                });
            <?php endforeach; ?>
        searchButton.addEventListener('click', function() {
          var geocoder = new google.maps.Geocoder();
          geocoder.geocode({ address: searchInput.value }, function(results, status) {
            if (status === 'OK') {
              if (results[0]) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
                });
              } else {
                alert('검색 결과를 찾을 수 없습니다.');
              }
            } else {
              alert('검색에 실패했습니다. 다시 시도해주세요.');
            }
          });
        });

          // 지도 클릭 이벤트 리스너 등록
          map.addListener('click', function(e) {
            // 클릭한 위치의 위도와 경도 가져오기
            var clickedLat = e.latLng.lat();
            var clickedLng = e.latLng.lng();

            // 알림창 표시하여 위치 변경 확인
            var confirmResult = confirm('선택한 위치로 변경하시겠습니까?');
            if (confirmResult) {
              // 마커 위치 변경
              marker.setPosition({lat: clickedLat, lng: clickedLng});
              // 지도 중심 위치 변경
              map.setCenter({lat: clickedLat, lng: clickedLng});

              // 현재 위치 정보를 GET 파라미터로 추가하여 main.php로 이동
              var url = 'main.php?lat=' + clickedLat + '&lng=' + clickedLng;
              window.location.href = url;
            }
          });
        });
      } else {
        // Geolocation을 지원하지 않는 경우의 처리
        alert('Geolocation을 지원하지 않습니다.');
      }
    }
  </script>

  <!-- Google Maps API 로드 -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgknUPj1dae6P2qe5Z7FNuxTn7sinn5_4&callback=initMap"></script>
</body>
</html>
