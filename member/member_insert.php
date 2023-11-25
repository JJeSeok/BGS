<?php
    $id= $_POST['id'];
    $pass= $_POST['pass'];
    $name= $_POST['name'];
    $phnum= $_POST['phnum'];
    $email= $_POST['email'];
    $birth1= $_POST['yy'];
    $birth2= $_POST['mm'];
    $birth3= $_POST['dd'];
    $birth=$birth1.$birth2.$birth3;
    $gender=$_POST['gender'];


    // 등록일
    $regist_day= date("Y-m-d H:i"); //2020-01-08 (14:19)

    // 레벨은 신규회원은 9,포인트는 0점으로 기본설정

    include "../lib/dbconn.php";

    // 중복된 아이디 여부를 확인해서 사용자에게 안내
    $sql= "SELECT * FROM member WHERE id='$id'";
    $result= mysqli_query($conn, $sql);
    $rowNum= mysqli_num_rows($result); //결과표로부터 레코드 수 얻어오기

    // 혹시 $rowNum이 0이 아니면 id가 있다는 것이므로 중복!!
    if($rowNum){
        // 경고창을 보여주면서 이전 회원가입 페이지로 다시 이동
        // history.back()  : 이전 페이지로 이동
        echo("
            <script>
                alert('해당 아이디가 존재합니다.');
                history.back(); 
            </script>
        ");
        // 중복이 되었으니 다음 작업들 못하도록.. php 종료
        exit;
    }

    //exit가 안되었다면 신규 id라는 것임
    //회원정보 insert

    //insert 쿼리문
    $sql= "INSERT INTO member(id, pass, name, phnum, email, regist_day, level,birth,gender) 
            VALUES('$id','$pass','$name', '$phnum', '$email','$regist_day','9','$birth','$gender')";

    // 쿼리문 실행
    mysqli_query($conn,$sql);
    mysqli_close($conn);

    // 데이터 저장이 완료된 후 index.php로 페이지 이동
    echo "
        <script>
        window.location.href='../index.php';
        </script>
    ";
?>