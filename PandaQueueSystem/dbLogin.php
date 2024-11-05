<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "queue_system";

$conn = new mysqli($servername, $Username, $Password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}
