<?php
session_start();
require_once('../config/database.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM sadmin WHERE adminusername = ? AND adminpassword = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1){
        $_SESSION['uid'] = 1;
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System Registration</title>
    <link rel="stylesheet" href="../assets/index.css">
</head>
<body>
<div class="left-side">
        <img src="../assets/vote.jpg" alt="Image">
    </div>
    <div class="right-side">
        <nav>
            <a href="../login.php" class="signin-btn">Signin as User</a>
        </nav>   
    <div class="container">
        <h2> Admin Login</h2>
        <form action="adminlogin.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>  
</html>
