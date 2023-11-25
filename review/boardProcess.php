<?php
    require_once("../lib/dbconn.php");
    session_start();
    $redate= date("Y-m-d H:i");
            if(!$_SESSION['userid']){
                echo("로그인 해주세요");
            }

            $id = $_POST['id'];
            $userid = $_POST['userid'];
            $name = $_POST['name'];
            $story = $_POST['story'];
            $star_rate = $_POST['rating']/2;
            if(!$id&&!$userid&&!$name&&!$story&&!$starate){
                header("location:../index.php?no=". urlencode($id));
            }
            $sql= "INSERT INTO review(id, userid, name, story, redate, star_rate) 
            VALUES('$id','$userid','$name', '$story','$redate','$star_rate')";
            mysqli_query($conn,$sql);
            $sql2= "select * from review order by num desc limit 1";
            $result2= $conn->query($sql2);
            $row = $result2 -> fetch_assoc();
            $renum=$row['num'];
            if($_FILES['image']['name']){
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
                VALUES('$newImage','$id','$userid','$renum')";
                mysqli_query($conn,$sql2);
            }
         }
            header("location:../foodpage.php?no=". urlencode($id));
?>