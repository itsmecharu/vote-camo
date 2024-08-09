<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: adminlogin.php");
    exit();
}

$currentPage = 'candidate'; // Set this to the page name
?>
<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $candidatename = $_POST['candidatename'];
    $id = $_POST['id'];
    $batch=$_POST['batch'];
    $faculty=$_POST['faculty'];


    // Check if the candidate ID already exists
    $checkSql = "SELECT * FROM candidates WHERE cid='$id'";
    $result = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($result) > 0) {
        // If the ID already exists, display an error message
        $error_message = "Error: The Candidate ID $id is already taken. Please choose a different ID.";
    } else {
        // If the ID is unique, insert the new candidate
        $sql = "INSERT INTO candidates(candidatename, cid, batch, faculty ) VALUES ('$candidatename', '$id', '$batch', '$faculty')";

        if (mysqli_query($conn, $sql)) {
            header("Location: admindashboard.php");
            exit();
        } else {
            $error_message = "ERROR: Sorry, there was a problem with the query. " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Form</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<div class="udcontainer">
    <nav class="navbar">
        <ul>
            <li><a href="admindashboard.php">Home</a></li>
            <li><a href="candidate.php" class="active">Add Candidate</a></li>
            <li><a href="result.php">Vote info</a></li>
            <li><a href="adminlogout.php">Logout</a></li>
        </ul>
    </nav>
</div>
<div class="form-container">
    <form class="candidate-form" action="" method="post">
        <p>Add Candidate</p>
        <?php
        if (isset($error_message)) {
            echo '<h4 class="error" style="color:red" >' . $error_message . '</h4>';
        }
        ?>
        <label for="candidatename">Candidate Name:</label>
        <input type="text" id="candidatename" name="candidatename" required>
        <label for="id">Candidate ID:</label>
        <input type="number" id="id" name="id" required>
        <label for="batch">Batch:</label>
                <select name="batch" id="batch" required>
                   <option value="2078">2078</option>
                   <option value="2079">2079</option>
                   <option value="2080">2080</option>
                 </select>

                <label for="faculty">Faculty:</label>
                <select name="faculty" id="faculty" required>
                   <option value="BBS">BBS</option>
                   <option value="BIM">BIM</option>
                   <option value="BCA">BCA</option>
                   <option value="B.SC CSIT">B.SC CSIT</option>
                   <option value="BHM">BHM</option>
                 </select>

        <input type="submit" value="Submit">
    </form>
</div>
<?php include 'afooter.php'; ?>
</body>
</html>
