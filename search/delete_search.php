<?php
    include "../lib/dbconn.php";
    session_start();
    $name=$_GET['keyword'];
    $id=$_SESSION['userid'];
    $sql ="DELETE from searchhistory where userid='$id' && searchKeyword='$name' LIMIT 1";
    mysqli_query($conn, $sql);
    mysqli_close($conn); 

    echo "
        <script>
        history.back();
        </script>
    ";
?>