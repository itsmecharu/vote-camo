<?php
$title = "Vote";
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $cid= $_POST['cid'];
     $crn = $_POST['crn'];

    $sql = "INSERT INTO votes (cid,crn) VALUES ('$cid','$crn')";

    if (mysqli_query($conn, $sql)) {
      header("Location: userdashboard.php");
      
    } else {
      echo "Error adding the details: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql="SELECT *FROM votes WHERE cid=(SELECT MAX(cid)FROM votes)";
$result=mysqli_query($conn,$sql);


