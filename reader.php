<?php
session_start();
require 'db.php';

if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT b.id, b.title, b.subtitle, b.content, b.image_url, b.status, b.created_at, a.username,
               (SELECT COUNT(*) FROM likes WHERE blog_id = b.id) AS like_count
        FROM blog_table b 
        JOIN admin a ON b.admin_id = a.id
        ORDER BY b.created_at DESC";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reader Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            height: 100%;
            background-color: #121212;
            color: #f9f9f9;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/reader1.jpg');
            background-size: cover;
            background-position: center;
            filter: brightness(0.3) blur(8px);
            z-index: -1;
        }

        .container {
            padding-top: 80px;
            padding-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        .navbar {
    background-color: #1c1c1c;
    height: 80px; /* Fixed height */
    padding: 0; /* Remove default padding */
    display: flex;
    align-items: center; /* Center vertically */
}


.navbar-brand {
    font-weight: 600;
    color: #ffffff !important;
    font-size: 1.1rem; /* Slightly smaller */
    padding-left: 10px;
}


        .footer {
            background-color: #1f1f1f;
            text-align: center;
            padding: 20px;
            color: #bbb;
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 40px;
            color: #ffffff;
            animation: fadeInDown 1s ease;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            color: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .card-img-top {
            max-height: 300px;
            object-fit: cover;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            filter: brightness(0.8);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #ffffff;
        }

        .card-text, .text-muted {
            color: #e0e0e0 !important;
        }

        .btn-outline-primary {
            border-radius: 12px;
            font-weight: 500;
            transition: 0.3s ease;
            border-color: #6c63ff;
            color: #6c63ff;
        }

        .btn-outline-primary:hover {
            background-color: #6c63ff;
            color: white;
        }

        .btn-secondary {
            background: #333;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            transition: 0.3s ease;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #555;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="background-overlay"></div>

<!-- Header / Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">📚 Reader's Lounge</a>
        <div class="ms-auto">
            <a href="logout.php" class="btn btn-secondary">🚪 Logout</a>
        </div>
    </div>
</nav>


<!-- Main Content -->
<div class="container">
    <h2>Welcome to the Reader's Blog Lounge</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card mb-4">
                <?php if (!empty($row['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="Blog Image">
                <?php endif; ?>
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                    <h6 class="text-muted"><?php echo htmlspecialchars($row['subtitle']); ?></h6>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 300))) . '...'; ?></p>
                    <p class="text-muted mt-3">
    <strong>Author:</strong> <?php echo htmlspecialchars($row['username']); ?> |
    <strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?> |
    <strong>Date:</strong> <?php echo date('F j, Y', strtotime($row['created_at'])); ?> |
    <strong>👍 Likes:</strong> <?php echo $row['like_count']; ?>
</p>

                    <a href="view_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary mt-2">📖 Read More & Comment</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center text-muted">No blogs available yet.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="footer mt-auto">
    <p>&copy; <?php echo date("Y"); ?> Reader's Lounge. All rights reserved.</p>
</footer>

</body>
</html>
