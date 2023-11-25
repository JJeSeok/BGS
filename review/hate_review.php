<?php
require_once("../lib/dbconn.php");
session_start();
if(!$_SESSION['userid']){
    echo"<script>alert('로그인 후 작성할 수 있습니다.'); history.back(); </script>";
}
$num=$_GET['hate'];
$hate_id=$_GET['hate_id'];
$userid=$_SESSION['userid'];
$sql="INSERT INTO hate_review(userid,renum,hate_id) VALUES('$userid','$num','$hate_id')";
mysqli_query($conn,$sql);
$sql3= "UPDATE review SET hate_count=hate_count+1 WHERE num='$num'";
mysqli_query($conn,$sql3);
echo '<script>history.back();</script>';             
?>