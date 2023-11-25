<?php
include "../lib/dbconn.php";
$num = $_POST['reviewId'];
$sql = "SELECT * from image where renum = '$num'";
$result= mysqli_query($conn,$sql);
$imagePaths = array();
while ($row = mysqli_fetch_array($result)) {
    $imagePaths[] = $row['db_filename'];
}
echo json_encode(array('image' => $imagePaths));
?>