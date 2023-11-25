<?php
session_start();
if(isset($_SESSION['lat'])||isset($_SESSION['lng'])){
    header("location:main4.php");
} else{
    header("location:main2.php");
}
?>