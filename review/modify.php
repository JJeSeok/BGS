<?php
    require_once("../lib/dbconn.php");
    session_start();
    if(isset($_POST['story'])&&isset($_POST['rating'])){
    $redate= date("Y-m-d H:i");
    $num=$_GET['num'];
    $id = $_POST['id'];
    $userid = $_POST['userid'];
    $name = $_POST['name'];
    $story = $_POST['story'];
    $star_rate = $_POST['rating']/2;
    if(!$id&&!$userid&&!$name&&!$story&&!$star_rate){
        header("location:../index.php?no=". urlencode($id));
    }
    $sql= "UPDATE review SET story='$story', star_rate='$star_rate', redate= '$redate' WHERE num='$num'";
    mysqli_query($conn,$sql);
    if(isset($_FILES['image'])){
        $countfiles = count($_FILES['image']['name']);
        for($i=0;$i<$countfiles;$i++){
        $imageFullName = strtolower($_FILES['image']['name'][$i]);
        $imageNameSlice = explode(".",$imageFullName);
        $imageName = $imageNameSlice[0];
        $imageType = $imageNameSlice[1];
        $image_ext = array('jpg','jpeg','gif','png');
        if(array_search($imageType,$image_ext) === false){
            echo("jpg, jpeg, gif, png 확장자만 가능합니다.");
        }
        $dates = date("mdhis",time());
        $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
        $dir = "image/";
        move_uploaded_file($_FILES['image']['tmp_name'][$i],$dir.$newImage);
        chmod($dir.$newImage,0777);
        $sql2="INSERT INTO image(db_filename,id,userid,renum)
        VALUES('$newImage','$id','$userid','$num')";
        mysqli_query($conn,$sql2);
        }
    }
    header("location:../mypage/my_page.php");
} else{
    echo "
    <script>
        alert('형식을 채워주세요.');
        history.back();
    </script>
    ";
}
?>