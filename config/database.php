<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "votcamp";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    // echo "Database created successfully.";
} else {
    die("ERROR: Could not create database. " . mysqli_error($conn));
}

// Connect to the newly created database

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect to the database. " . mysqli_connect_error());
}

// Create table for users
$sql = "CREATE TABLE IF NOT EXISTS users(
    crn INT PRIMARY KEY NOT NULL,
    username VARCHAR(30) NOT NULL,
    batch YEAR NOT NULL,                     -- Batch year (e.g., 2078, 2079, 2080)
    faculty VARCHAR(50) NOT NULL,
    userpassword VARCHAR(255) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    // echo "Table 'users' created successfully.";
} else {
    echo "Error creating 'users' table: " . mysqli_error($conn);
}

// Create table for Admin
$sql = "CREATE TABLE IF NOT EXISTS sadmin(
    sid INT PRIMARY KEY AUTO_INCREMENT,
    adminusername VARCHAR(30) NOT NULL,
    adminpassword VARCHAR(255) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    // echo "Table 'sadmin' created successfully.";
} else {
    echo "Error creating 'sadmin' table: " . mysqli_error($conn);
}

// Insert default admin user (INSERT IGNORE ensures no duplicate entry if it already exists)
$sql = "INSERT IGNORE INTO sadmin (sid, adminusername, adminpassword) VALUES (1,'admin123', 'admin123')";
if (mysqli_query($conn, $sql)) {
    // echo "Admin user inserted successfully.";
} else {
    echo "Error inserting admin user: " . mysqli_error($conn);
}

// Create table for candidates
$sql = "CREATE TABLE IF NOT EXISTS candidates(
    cid INT PRIMARY KEY ,
    candidatename VARCHAR(30) NOT NULL,
    batch INT NOT NULL,
    faculty VARCHAR(30) NOT NULL 
)";
if (mysqli_query($conn, $sql)) {
    // echo "Table 'candidates' created successfully.";
} else {
    echo "Error creating 'candidates' table: " . mysqli_error($conn);
}

// Create table for votes

$sql = "CREATE TABLE IF NOT EXISTS votes(
    vid INT PRIMARY KEY AUTO_INCREMENT,
    cid INT NOT NULL,
    crn INT  NOT NULL,
    FOREIGN KEY (cid) REFERENCES candidates(cid),
    FOREIGN KEY (crn) REFERENCES users(crn)
    

)";
if (mysqli_query($conn, $sql)) {
    // echo "Table 'candidates' created successfully.";
} else {
    echo "Error creating 'candidates' table: " . mysqli_error($conn);
}


//vote_state table
$sql = "CREATE TABLE IF NOT EXISTS vote_status(
    vote_state_id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

if (mysqli_query($conn, $sql)) {
    //echo "Table Created Successfully.";
} else {
    echo "<br>";
    echo "Error Creating table" . mysqli_error($conn);
}
