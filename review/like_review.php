<?php
require_once("../lib/dbconn.php");
session_start();
if(!$_SESSION['userid']){
    echo"<script>alert('로그인 후 작성할 수 있습니다.'); history.back(); </script>";
}
$num=$_GET['like'];
$like_id=$_GET['like_id'];
$userid=$_SESSION['userid'];
$sql="INSERT INTO like_review(userid,renum,like_id) VALUES('$userid','$num','$like_id')";
mysqli_query($conn,$sql);
$sql3= "UPDATE review SET like_count=like_count+1 WHERE id='$num'";
mysqli_query($conn,$sql3);
$sql2="SELECT COUNT(*) AS count FROM like_review WHERE like_id = '$like_id'";
$result2 = $conn->query($sql2);
$row = $result2->fetch_assoc();
$count = $row['count'];
if ($count >= 4) {
    // 멤버 테이블의 level을 1 감소시킵니다.
    $sqlUpdateLevel = "UPDATE member SET level = level - 1 WHERE id = '$like_id'";
    mysqli_query($conn, $sqlUpdateLevel);
}
echo '<script>history.back();</script>';             
?>