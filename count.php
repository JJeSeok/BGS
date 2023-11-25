<?php
include "./lib/dbconn.php";
session_start();
$num=$_GET['no'];
if(isset($_SESSION['userid'])){
function calculateAge($birthdate) {
    $date = DateTime::createFromFormat('Ymd', $birthdate);
    if (!$date) {
        return false; // 유효하지 않은 날짜 형식의 경우
    }
    $today = new DateTime('today');
    $age = $date->diff($today)->y;
    return $age;
}

// 예제 사용법
$birthdate = $_SESSION['birth']; // "년도월일" 형식
$gender = $_SESSION['gender'];
$age = calculateAge($birthdate);
if($age>=20 && $age<30 && $gender == 'M') {
    $sql2 = "UPDATE inquery
    SET twenty_m = twenty_m + 1
    WHERE food_num = '$num'";    
}
else if($age>=20 && $age<30 && $gender == 'F') {
    $sql2 = "UPDATE inquery
    SET twenty_f = twenty_f + 1
    WHERE food_num = '$num'";    
}
else if($age>=30 && $age<40 && $gender == 'M') {
    $sql2 = "UPDATE inquery
    SET thirty_m = thirty_m + 1
    WHERE food_num = '$num'";  
}
else if($age>=30 && $age<40 && $gender == 'F') {
    $sql2 = "UPDATE inquery
    SET thirty_f = thirty_f + 1
    WHERE food_num = '$num'";  
}
else if($age>=40 && $age<50 && $gender == 'M') {
    $sql2 = "UPDATE inquery
    SET fourty_m = fourty_m + 1
    WHERE food_num = '$num'";  
}
else if($age>=40 && $age<50 && $gender == 'F') {
    $sql2 = "UPDATE inquery
    SET fourty_f = fourty_f + 1
    WHERE food_num = '$num'"; 
}
else if($age>=50 && $age<60 && $gender == 'M') {
    $sql2 = "UPDATE inquery
    SET fifty_m = fifty_m + 1
    WHERE food_num = '$num'";  
}
else if($age>=50 && $age<60 && $gender == 'F') {
    $sql2 = "UPDATE inquery
    SET fifty_f = fifty_f + 1
    WHERE food_num = '$num'";   
}
$sql="UPDATE food SET count=count+1 WHERE num='$num'";
mysqli_query($conn,$sql);
mysqli_query($conn,$sql2);
echo "
    <script>
        location.href='./foodpage.php?no=".$num."';
    </script>
    ";
}
else{
    echo "
    <script>
        location.href='./foodpage.php?no=".$num."';
    </script>
    "; 
}    
?>