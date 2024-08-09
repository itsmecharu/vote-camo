<?php
session_start();

include 'config/database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$crn=$_POST['crn'];
$userpassword=$_POST['userpassword'];
$check = mysqli_query($conn,"SELECT * FROM users WHERE crn='$crn' AND userpassword='$userpassword'");
if ($check->num_rows > 0) {
    $_SESSION['crn'] = $crn;
    header("Location: userdashboard.php");
    exit();
} else {
    $error_message = "Invalid Credentials";
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote-Camp User Login</title>
    <link rel="stylesheet" href="assets/index.css">
   
</head>
<body>
    <div class="left-side">
        <img src="assets/vote.jpg" alt="Image">
    </div>
    <div class="right-side">
        <nav>
            <a href="admin/adminlogin.php" class="signin-btn">Signin as Admin</a>
        </nav>
        <div class="container">
            <h2>User Login</h2>

            <?php
            if (!empty($error_message)) {
                echo '<div class="error-message" style="color:red;">' . $error_message . '</div>';
            }
            ?>
            
            <form method="post" action="" onsubmit="return validateForm()">
                <label for="crn">CRN Number:</label>
                <input type="text" id="crn" name="crn" required>
                <label for="password">Password:</label>
                <input type="password" id="userpassword" name="userpassword" required>
                <button type="submit" class="login-btn">Login</button>
                <p>Don't have an account? <a href="register.php">SignUp</a></p>
            </form>
        </div>
    </div>
</body>
</html>