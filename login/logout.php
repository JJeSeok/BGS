<?php

    // 로그아웃은 세션만 지우면 됨
    session_start();

    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    unset($_SESSION['userlevel']);
    unset($_SESSION['email']);
    unset($_SESSION['phnum']);
    unset($_SESSION['gender']);
    unset($_SESSION['birth']);

    // index페이지로 돌아가기
    echo "
    <script>
        location.href='../index.php';
    </script>
    ";

?>