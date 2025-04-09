<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT b.title, c.comment, c.created_at, r.name AS reader_name 
        FROM comments c 
        JOIN blog_table b ON c.blog_id = b.id 
        JOIN reader r ON c.reader_id = r.id 
        WHERE b.admin_id = $admin_id 
        ORDER BY c.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">Comments on Your Blogs</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['comment']); ?></p>
                    <p class="text-muted">By <strong><?php echo htmlspecialchars($row['reader_name']); ?></strong> on <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No comments yet on your blogs.</p>
    <?php endif; ?>

    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

</body>
</html>
