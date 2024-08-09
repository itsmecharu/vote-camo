<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: adminlogin.php");
    exit();
}

require_once('../config/database.php');
$sql = "SELECT * FROM candidates";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href='../assets/styles.css'>
</head>
<body>
<div class="udcontainer">
    
    <nav class="navbar">
    <ul>
        <li><a href="admindashboard.php" class="active">Home</a></li>
        <li><a href="candidate.php" >Add Candidate</a></li>
        <li><a href="result.php" >Vote info</a></li>
        <li><a href="adminlogout.php" >Logout</li></a>
    </ul>
</nav>
</div>
 <!-- Vote start and End button -->
 <?php 
                             $sql = "SELECT * FROM vote_status WHERE status = 'T'";
                                 $sresults = mysqli_query($conn, $sql); 
                                 $scount = mysqli_num_rows($sresults);
                                if ($scount > 0) {
                                ?>  
                                <form action="end.php" method="POST" style="margin-left: auto;">
                                <button type="submit" name="endvote" class="delete-button" style="background-color: red; color: white;
                                 padding: 10px 50px; border: none;align-items: center;  border-radius: 22px; cursor: pointer;">
                                End Vote
                                </button>
                                </form>
                             <?php 
                            } else {     
                                      ?>  
                                  <form action="start.php" method="POST" style="margin-left: auto;">
                                  <button type="submit" name="startvote" class="delete-button" style="background-color: blue; color: white;
                                   padding: 10px 50px; align-items: center; border: none; border-radius: 22px; cursor: pointer;">
                                 Start Vote Now
                               </button>
                                </form>
                               <?php 
        } 
        ?>
        <div class="table-container">
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align:center;">Candidate's Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>
                                        <div class='candidates'>
                                            <div class='candidate' style='width:90%;'>
                                                <span class='candidate-name'>{$row['candidatename']}</span>
                                                <span class='candidate-batch'>{$row['batch']}</span>
                                                <span class='candidate-faculty'>{$row['faculty']}</span>
                                            </div>
                                        </div>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td>No candidates found.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php include 'afooter.php'; ?>
    </div>
</body>
</html>
