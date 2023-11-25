<?php
    include "../lib/dbconn.php";
    session_start();
    if(!$_SESSION['userid']){
        echo"<script>alert('로그인 후 작성할 수 있습니다.'); history.back(); </script>";
    }
    $num=$_GET['like'];
    $like_id=$_GET['like_id'];
    $userid=$_SESSION['userid'];
    $sql = "DELETE from like_review where userid='$userid' && renum='$num' && like_id='$like_id'";
    mysqli_query($conn, $sql);
    $sql3= "UPDATE review SET like_count=like_count-1 WHERE num='$num'";
    mysqli_query($conn,$sql3);

    echo "
        <script>
        history.back();
        </script>
    ";
?>