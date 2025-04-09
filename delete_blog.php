<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$adminId = $_SESSION['admin_id'];
$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ensure blog belongs to this admin
$stmt = $conn->prepare("SELECT id FROM blog_table WHERE id = ? AND admin_id = ?");
$stmt->bind_param("ii", $blogId, $adminId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Blog not found or unauthorized access.";
    exit();
}

// Perform deletion
$deleteStmt = $conn->prepare("DELETE FROM blog_table WHERE id = ? AND admin_id = ?");
$deleteStmt->bind_param("ii", $blogId, $adminId);

if ($deleteStmt->execute()) {
    // ✅ Redirect with query parameter after successful delete
    header("Location: dashboard.php?deleted=1");
    exit();
} else {
    echo "Error deleting blog: " . $deleteStmt->error;
}

$deleteStmt->close();
$stmt->close();
?>
