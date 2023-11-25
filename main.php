<?php
// update_location.php

// 좌표 값 받아오기
$latitude = $_GET['lat'];
$longitude = $_GET['lng'];

// 좌표를 데이터베이스에 저장하거나 세션 변수로 저장하는 등의 로직을 수행할 수 있습니다.

// 예시: 세션 변수에 저장
session_start();
$_SESSION['lat'] = $latitude;
$_SESSION['lng'] = $longitude;

// 응답 반환
echo '현재 위치가 업데이트되었습니다.';
echo '<script> window.history.go(-2); </script>';
?>
