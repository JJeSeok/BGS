<?php
    
    //id만 GET으로 전달받을 수 있음
    $id= $_GET['id'];

    // post로 전달받은 값들
    $before_pass = $_POST['originalPassword'];
    $pass = $_POST['newPassword'];
    $pass_check = $_POST['newPasswordConfirm'];
    $name = $_POST['name'];
    $phnum =$_POST['mobileNumber'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $birthYear = $_POST['birthYear'];
    $birthMonth = $_POST['birthMonth'];
    $birthDay = $_POST['birthDay'];
    $birth = $birthYear + $birthMonth + $birthDay;
    if(!($pass==$pass_check)){
        echo "
        <script>
            alert('새비밀번호를 다시 입력해주세요');
            history.back();
        </script>
        ";
    }
    include "../lib/dbconn.php";

    // 업데이트 쿼리문
    $sql= "UPDATE member SET pass='$pass', name='$name', phnum='$phnum', email='$email',birth='$birth',gender='$gender' WHERE id='$id'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    echo "
    <script>
        location.href='../mypage/my_page.php';
    </script>
    ";

?>