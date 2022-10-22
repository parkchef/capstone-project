<?php
$servername = "192.168.1.6";
$username = "parkchansu39";
$password = "1Q2w3e4r!@";
$db_name = "capstone_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
