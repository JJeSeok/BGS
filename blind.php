<?php
include "./lib/dbconn.php";  
session_start(); //세션을 저장하든 읽어오든 사용하고자 하면 이 함수로 시작
if(!$_SESSION['userid']){
    echo"<script>alert('로그인 후 작성할 수 있습니다.'); history.back(); </script>";
}
$userid="";
$username="";
$userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
$userpoint="";
   
if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
if( isset($_SESSION['username'])) $username= $_SESSION['username'];
if( isset($_SESSION['userlevel'])) $userlevel= $_SESSION['userlevel'];
if( isset($_SESSION['userphnum'])) $userpoint= $_SESSION['userphnum'];

$yourid=$_GET['yourid'];
$sql= "INSERT INTO blind(myid,yourid) 
VALUES('$userid','$yourid')";
mysqli_query($conn, $sql);

echo "<script> history.back(); </script>";
?>