<?php
session_start();
$crn = $_SESSION['crn'];

if (!isset($_SESSION['crn'])) {
    header("location: index.php");
}
$title = "Results";
include_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href='assets/styles.css'> 
</head>
<body>
<div class="udcontainer">
        <nav class="navbar">
            <ul>
                <li><a href="userdashboard.php">Home</a></li>
                <li><a href="result.php" class="active">Result</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h1>Election Results</h1>
        <div class="candidate-list">
            <?php
            $sql = "SELECT * FROM candidates";
            $collection = mysqli_query($conn, $sql);

            if ($collection) {
                $max_votes = 0;
                $winner = null;

                while ($item = mysqli_fetch_assoc($collection)) {
                    $cid = $item['cid'];
                    $vote_sql = "SELECT COUNT(*) as count FROM votes WHERE cid = $cid";
                    $total_vote_result = mysqli_query($conn, $vote_sql);

                    if ($total_vote_result) {
                        $total_vote = mysqli_fetch_assoc($total_vote_result);
                        $vote_count = $total_vote['count'];
                        
                        if ($vote_count > $max_votes) {
                            $max_votes = $vote_count;
                            $winner = $item;
                        }
                    } else {
                        echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
                    }
                }

                if ($winner) {
                    echo "<div class='winner'><strong>Candidate with Maximum Votes till now is:</strong><br>" . $winner['candidatename'] . "</div>";
                } else {
                    echo "<div class='error'>Winner not declared yet!</div>";
                }
            } else {
                echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
            }
            ?>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>
