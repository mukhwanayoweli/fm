<?php
// Database connection details
$servername = 'localhost';
$username = 'your_username';
$password = 'your_password';
$dbname = 'your_database_name';

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}
?>