<?php
session_start();
require 'db.php';

if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");
    exit();
}

$readerId = $_SESSION['reader_id'];
$blogId = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;

// Check if already liked
$stmt = $conn->prepare("SELECT * FROM likes WHERE blog_id = ? AND reader_id = ?");
$stmt->bind_param("ii", $blogId, $readerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $insert = $conn->prepare("INSERT INTO likes (blog_id, reader_id) VALUES (?, ?)");
    $insert->bind_param("ii", $blogId, $readerId);
    $insert->execute();
}

header("Location: view_blog.php?id=" . $blogId);
exit();
