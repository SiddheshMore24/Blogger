<?php
$host = 'localhost';
$user = 'root'; // change if you use another user
$password = 'siddhesh'; // change if you have a password
$database = 'blog_system';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
