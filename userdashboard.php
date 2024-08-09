<?php
session_start();
if (!isset($_SESSION['crn'])) {
    header("location: login.php");
    exit();  
}

$crn = $_SESSION['crn']; 
 
include_once 'config/database.php';
$sql = "SELECT * FROM candidates";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href='assets/styles.css'> 

    
</head>
<body>
<div class="udcontainer">
        <nav class="navbar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="userdashboard.php" class="active">Vote</a></li>
                <li><a href="result.php">Result</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    <?php 
    $sql = "SELECT * FROM vote_status WHERE status = 'T'";
    $sresults = mysqli_query($conn, $sql); 
    $scount = mysqli_num_rows($sresults);
    if ($scount > 0) {
?>
        
        <div class="table-container">
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Candidate Name</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $vote_check_sql = "SELECT * FROM votes WHERE crn= '$crn'";
                                $vote_check_result = mysqli_query($conn, $vote_check_sql);
                                $has_voted = mysqli_num_rows($vote_check_result) > 0;
                                
                                $cid = $row['cid'];
                                
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['candidatename']),($row['batch']),($row['faculty']) . "</td>
                                    <td style='text-align:center;'>
                                        <form method='POST' action='vote.php'>";
                                
                                if (!$has_voted) {
                                    echo "<input type='hidden' name='cid' value='" . htmlspecialchars($row['cid']) . "'>
                                          <input type='hidden' name='crn' value='" . htmlspecialchars($crn) . "'>
                                          <button type='submit' class='delete-button' style='background-color: #3B43D6;'>Vote</button>";
                                } else {
                                    echo "<button type='button' class='delete-button' style='background-color: #32CD32;' disabled>Voted</button>";
                                }

                                echo "    </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No candidates found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
    }else{
?>
<h1 style="margin:1px 0px;text-align: center;padding:10rem; background-color:#E2E7E6;">VOTING LINE CLOSED</h1>

</div>
    
<?php } include 'footer.php'; ?>
</body>
</html>
