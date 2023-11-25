<?php
$name=$_POST['name2'];
$email=$_POST['email'];
include "../lib/dbconn.php";

$sql = "SELECT id FROM member WHERE name='$name' && email='$email'";
$result= mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

if($row){
	echo "<script>alert('회원님의 ID는 ".$row[0]."입니다.'); history.back();</script>";
}else{
    echo "<script>alert('없는 계정입니다.".$row[0]."'); history.back();</script>";
}
?>