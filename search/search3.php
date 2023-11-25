<?php
        include "../lib/dbconn.php";
        session_start();
        if(isset($_GET['keyword'])){
            $name=$_GET['keyword'];
        }
        else{
        $name=$_POST['main-search'];
        }
        if(isset($_SESSION['userid'])){
            $userid=$_SESSION['userid'];
            $sql2 = "SELECT * FROM searchhistory WHERE userid='$userid' AND searchKeyword='$name'";
            $result = mysqli_query($conn, $sql2);
            if(mysqli_num_rows($result) == 0){
                $sql= "INSERT INTO searchhistory(userid, searchKeyword) 
                VALUES('$userid','$name')";
                mysqli_query($conn,$sql);
            }
            else{
                $sql= "INSERT INTO searchhistory(userid, searchKeyword) 
                VALUES('$userid','$name')";
                $sql3 ="DELETE from searchhistory where userid='$userid' && searchKeyword='$name'";
                mysqli_query($conn,$sql3);
                mysqli_query($conn,$sql);
            }
        }
        $sql="select * from food where name LIKE '%$name%'";
        $result= mysqli_query($conn,$sql);
        $row=$result->fetch_assoc();
        if($row){
            echo "
            <script>
            window.location.href='./search.php?fname=$name';
            </script>
            ";
        }

        else{
            echo "
            <script>
            window.location.href='./search4.php?fname=$name';
            </script>
            ";
        }
?>