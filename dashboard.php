<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$adminId = $_SESSION['admin_id'];
$username = $_SESSION['username'];

// Fetch all blogs by this admin
$stmt = $conn->prepare("SELECT * FROM blog_table WHERE admin_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #f8f9fa;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 32, 39, 0.88);
            z-index: -1;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            color: #ffffff;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-title {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .card-text {
            color: #e6e6e6;
            font-size: 0.95rem;
        }

        .text-muted {
            color: #cccccc !important;
            font-size: 0.85rem;
        }

        .btn-warning, .btn-danger, .btn-success {
            color: white;
        }

        .header, .footer {
            background-color: #121212dd;
            color: white;
            padding: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 60px;
        }

        #toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        a {
            text-decoration: none;
        }

        .comment-box {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #00d1b2;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #ffffff;
        }

        .comment-box strong {
            color: #ffc107;
        }

        .comment-box small {
            color: #dddddd;
            font-size: 0.75rem;
        }

        .no-comments {
            color: #ccc;
            font-style: italic;
            font-size: 0.9rem;
        }

        h2, h4, h5, h6 {
            color: #fefefe;
        }

        hr.text-white {
            border-top: 1px solid #ffffff88;
        }

        .btn-outline-light {
            border-color: #ffffff;
            color: #ffffff;
        }

        .btn-outline-light:hover {
            background-color: #ffffff;
            color: #121212;
        }

        .btn-sm {
            padding: 0.35rem 0.6rem;
            font-size: 0.78rem;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <div class="container d-flex justify-content-between align-items-center">
        <h2>✍️ Admin Dashboard</h2>
        <div>
            <span class="me-3">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </div>
</div>

<!-- Toast Message -->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <div id="toast">Blog deleted successfully.</div>
    <script>
        setTimeout(() => {
            document.getElementById('toast').style.display = 'none';
        }, 3000);
    </script>
<?php endif; ?>

<!-- Main Content -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Your Blog Posts</h4>
        <a href="create_blog.php" class="btn btn-success">+ Create New Blog</a>
    </div>
    <hr class="text-white">

    <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $blogId = $row['id'];
                    // Fetch like count
                    $likeQuery = $conn->prepare("SELECT COUNT(*) as like_count FROM likes WHERE blog_id = ?");
                    $likeQuery->bind_param("i", $blogId);
                    $likeQuery->execute();
                    $likeResult = $likeQuery->get_result();
                    $likeData = $likeResult->fetch_assoc();
                    $likeCount = $likeData['like_count'] ?? 0;
                    $likeQuery->close();
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="text-muted mb-1"><strong>Status:</strong> <?php echo $row['status']; ?></p>
                            <p class="text-muted"><em>Posted on: <?php echo $row['created_at']; ?></em></p>
                            <p class="card-text"><?php echo nl2br(substr($row['content'], 0, 150)); ?>...</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center mb-2">
                                <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_blog.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');" class="btn btn-sm btn-danger">Delete</a>
                                <p class="text-muted mb-0"><i class="bi bi-heart-fill text-danger me-1"></i> <?php echo $likeCount; ?> Likes</p>
                            </div>
                            <div class="border-top pt-3">
                                <h6 class="mb-2 text-info">Comments:</h6>
                                <?php
                                $commentQuery = $conn->prepare("SELECT c.comment, c.created_at, r.username AS reader_name
                                                                FROM comments c
                                                                JOIN reader r ON c.reader_id = r.id
                                                                WHERE c.blog_id = ?
                                                                ORDER BY c.created_at DESC");
                                if ($commentQuery) {
                                    $commentQuery->bind_param("i", $blogId);
                                    $commentQuery->execute();
                                    $comments = $commentQuery->get_result();

                                    if ($comments->num_rows > 0):
                                        while ($comment = $comments->fetch_assoc()):
                                ?>
                                            <div class="comment-box">
                                                <p class="mb-1"><strong><?php echo htmlspecialchars($comment['reader_name']); ?>:</strong></p>
                                                <p class="mb-1"><?php echo htmlspecialchars($comment['comment']); ?></p>
                                                <small class="text-muted"><?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?></small>
                                            </div>
                                <?php
                                        endwhile;
                                    else:
                                        echo "<p class='no-comments'>No comments yet.</p>";
                                    endif;
                                    $commentQuery->close();
                                } else {
                                    echo "<p class='text-danger'>Error loading comments.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info bg-opacity-25">No blogs added yet.</div>
    <?php endif; ?>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; <?php echo date('Y'); ?> BlogWriter | Empowering writers with voice and reach 📚</p>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
