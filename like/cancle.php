<?php
    include "../lib/dbconn.php";
    session_start();
    if(!$_SESSION['userid']){
        echo"<script>alert('로그인 후 작성할 수 있습니다.'); history.back(); </script>";
    }
    $num=$_GET['no'];
    $id=$_SESSION['userid'];
    $sql = "DELETE from like_board where food_id='$num'&&id='$id'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    echo "
        <script>
        history.back();
        </script>
    ";
?>