<?php
    require_once("../lib/dbconn.php");
    session_start();
    if( !(isset( $_SESSION[ 'userid' ] )) ) {
        echo "
                <script>
                    alert('로그인후 사용해주세요');
                    history.back();
                </script>
                    ";
                exit;
      }
    $num=$_GET['no'];
    $regist_day= date("Y-m-d H:i");
    $id=$_SESSION['userid'];

    $sql= "SELECT * FROM like_board WHERE food_id='$num' && id='$id'";
    $result= mysqli_query($conn, $sql);
    $rowNum= mysqli_num_rows($result);

    if($rowNum){
        // 경고창을 보여주면서 이전 회원가입 페이지로 다시 이동
        // history.back()  : 이전 페이지로 이동
        echo("
            <script>
                alert('이미 좋아요된 음식점입니다.');
                history.back(); 
            </script>
        ");
        // 중복이 되었으니 다음 작업들 못하도록.. php 종료
        exit;
    }

    $sql= "INSERT INTO like_board(id,food_id,regist_day) 
            VALUES('$id','$num','$regist_day')";
    $sql2= "UPDATE food SET like_num = like_num+1 WHERE num = '$num'";
    mysqli_query($conn,$sql);
    mysqli_query($conn,$sql2);
    mysqli_close($conn);

    echo "
        <script>
        history.back();
        </script>
    ";

?>