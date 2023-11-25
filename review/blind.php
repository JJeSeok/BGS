<?php
    include "../lib/dbconn.php";
    session_start();
    $yourid=$_GET['id'];
    $id=$_SESSION['userid'];
    $sql="INSERT INTO blind(myid,yourid) VALUES('$id','$yourid')";
    mysqli_query($conn,$sql);
    mysqli_close($conn);
    echo "
        <script>
        // 변수에 이전페이지 정보를 저장
        
        window.location.href='./review2.php';
        </script>
    ";
?>