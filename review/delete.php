<?php
    include "../lib/dbconn.php";
    session_start();
    $num=$_GET['numb'];
    $id=$_SESSION['userid'];
    $sql ="DELETE from review where num='$num'";
    mysqli_query($conn, $sql);
    $sql2 = "DELETE from image where num='$num'";
    mysqli_query($conn, $sql2);
    mysqli_close($conn); 

    echo "
        <script>
        history.back();
        </script>
    ";
?>