<?php
 require_once("../lib/dbconn.php");
 session_start();
    if (isset($_POST['deletedImages'])) {
        // deletedImages가 배열인지 확인
        if (is_array($_POST['deletedImages'])) {
            // 각 파일 이름에 대해 루프
            foreach ($_POST['deletedImages'] as $filename) {
                $sql = "DELETE from image where db_filename = '$filename'";
                mysqli_query($conn,$sql);
            }
        }
        else{
            echo 'miss';
        }
    } else{
        echo 'fail';
    }
?>