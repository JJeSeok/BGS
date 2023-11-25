<?php
include "../lib/dbconn.php";
session_start();
$id = $_SESSION['userid'];
$password = $_POST['password'];
$sql = "SELECT * FROM member where id = '$id' && pass = '$password'";
$result= mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
if($row){
    echo 'correct';
}
else{
    echo 'incorrect';
}
?>