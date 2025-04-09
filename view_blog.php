<?php
session_start();
require 'db.php';

if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");
    exit();
}

$readerId = $_SESSION['reader_id'];
$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch blog
$stmt = $conn->prepare("SELECT b.*, a.username FROM blog_table b JOIN admin a ON b.admin_id = a.id WHERE b.id = ?");
$stmt->bind_param("i", $blogId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Blog not found.";
    exit();
}
$blog = $result->fetch_assoc();

// Insert comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);
    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (blog_id, reader_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $blogId, $readerId, $comment);
        $stmt->execute();
    }
}

// Fetch comments
$commentQuery = $conn->prepare("SELECT c.comment, c.created_at, r.username 
                                FROM comments c 
                                JOIN reader r ON c.reader_id = r.id 
                                WHERE c.blog_id = ? 
                                ORDER BY c.created_at DESC");
$commentQuery->bind_param("i", $blogId);
$commentQuery->execute();
$comments = $commentQuery->get_result();

// Check if user already liked
$likeCheck = $conn->prepare("SELECT COUNT(*) FROM likes WHERE blog_id = ? AND reader_id = ?");
$likeCheck->bind_param("ii", $blogId, $readerId);
$likeCheck->execute();
$likeCheck->bind_result($likeExists);
$likeCheck->fetch();
$alreadyLiked = $likeExists > 0;
$likeCheck->close();

// Get total likes
$likeCountQuery = $conn->prepare("SELECT COUNT(*) FROM likes WHERE blog_id = ?");
$likeCountQuery->bind_param("i", $blogId);
$likeCountQuery->execute();
$likeCountQuery->bind_result($likeCount);
$likeCountQuery->fetch();
$likeCountQuery->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-image: url('assets/reader1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 40px;
            border-radius: 20px;
            margin-top: 80px;
            margin-bottom: 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        h2, h4, h5 {
            color: #ffffff;
            font-weight: 600;
        }
        .text-muted {
            color: #bbb !important;
        }
        .form-control {
            background-color: #222;
            color: #f5f5f5;
            border: 1px solid #555;
        }
        .form-control::placeholder {
            color: #aaa;
        }
        .btn-primary {
            background-color: #6c63ff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #574bff;
        }
        .btn-secondary {
            background: #444;
            border: none;
        }
        .btn-secondary:hover {
            background: #666;
        }
        .bg-white {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #fff;
        }
        .border {
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        img {
            max-width: 100%;
            border-radius: 12px;
            margin-top: 20px;
        }
        p {
            color: #e0e0e0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
    <h5 class="text-muted"><?php echo htmlspecialchars($blog['subtitle']); ?></h5>
    <p><strong>By:</strong> <?php echo htmlspecialchars($blog['username']); ?> on <?php echo date('F j, Y', strtotime($blog['created_at'])); ?></p>
    <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>

    <?php if (!empty($blog['image_url'])): ?>
        <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image">
    <?php endif; ?>

    <hr class="text-light">

    <!-- Like Button -->
    <form method="POST" action="like_blog.php">
        <input type="hidden" name="blog_id" value="<?php echo $blogId; ?>">
        <button type="submit" class="btn btn-outline-<?php echo $alreadyLiked ? 'success' : 'primary'; ?>" 
                <?php echo $alreadyLiked ? 'disabled' : ''; ?>>
            👍 Like (<?php echo $likeCount; ?>)
        </button>
    </form>

    <hr>

    <!-- Comment Section -->
    <h4>💬 Leave a Comment</h4>
    <form method="POST" class="mb-4">
        <textarea name="comment" class="form-control" rows="3" placeholder="Write your comment here..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
    </form>

    <h5>🗨 Comments</h5>
    <?php if ($comments->num_rows == 0): ?>
        <p class="text-muted">No comments yet. Be the first to comment!</p>
    <?php else: ?>
        <?php while ($c = $comments->fetch_assoc()): ?>
            <div class="border rounded p-2 mb-3 bg-white">
                <strong><?php echo htmlspecialchars($c['username']); ?></strong>
                <small class="text-muted">on <?php echo date('F j, Y', strtotime($c['created_at'])); ?></small>
                <p><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

    <a href="reader.php" class="btn btn-secondary mt-4">← Back to Dashboard</a>
</div>

</body>
</html>
