<?php
include "../lib/dbconn.php";
session_start();

if (!$_SESSION['userid']) {
    echo "로그인 후 작성할 수 있습니다.";
    exit;
}

$num = $_GET['no'];
$id = $_SESSION['userid'];

// 좋아요 상태 확인
$check_sql = "SELECT * FROM like_board WHERE food_id='$num' AND id='$id'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // 이미 좋아요한 경우, 좋아요 취소
    $delete_sql = "DELETE FROM like_board WHERE food_id='$num' AND id='$id'";
    mysqli_query($conn, $delete_sql);
    echo "cancled";
} else {
    // 아직 좋아요하지 않은 경우, 좋아요 추가
    $insert_sql = "INSERT INTO like_board (food_id, id) VALUES ('$num', '$id')";
    mysqli_query($conn, $insert_sql);
    echo "liked";
}

mysqli_close($conn);
?>