<?php
    include "../lib/dbconn.php";
    session_start();
    if(!$_SESSION['userid']){
        echo"<script>alert('로그인 후 작성할 수 있습니다.'); history.back(); </script>";
    }
    $num=$_GET['hate'];
    $hate_id=$GET['hate_id'];
    $userid=$_SESSION['userid'];
    $sql = "DELETE from hate_review where userid='$userid' && renum='$num' && hate_id='$hate_id";
    mysqli_query($conn, $sql);
    $sql3= "UPDATE review SET hate_count= hate_count-1 WHERE num='$num'";
    mysqli_query($conn,$sql3);
    echo "
        <script>
        history.back();
        </script>
    ";
?>