<?php
session_start();
require 'db.php';

// Redirect if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$adminId = $_SESSION['admin_id'];

// Handle blog submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO blog_table (admin_id, title, subtitle, content, image_url, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isssss", $adminId, $title, $subtitle, $content, $image_url, $status);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Blog</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e4e4e4;
}

.glass-card {
    background: rgba(20, 20, 20, 0.6);
    border-radius: 20px;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    padding: 2.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
    animation: fadeInUp 0.7s ease;
    width: 100%;
    max-width: 720px;
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

h3 {
    font-weight: 600;
    text-align: center;
    margin-bottom: 30px;
    color: #ffffff;
}

.form-label {
    font-weight: 500;
    color: #d1d1d1;
}

.form-control,
.form-select {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    border-radius: 12px;
    padding: 10px 14px;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    transition: background 0.3s, border 0.3s;
}

.form-control::placeholder {
    color: #cccccc;
}

.form-control:focus,
.form-select:focus {
    background: rgba(255, 255, 255, 0.12);
    border-color: #8f94fb;
    color: #ffffff;
    box-shadow: 0 0 0 0.25rem rgba(143, 148, 251, 0.3);
}

.form-select option {
    background-color: #1e1e2f;
    color: #ffffff;
}

/* Button styling */
.btn-primary {
    border-radius: 12px;
    padding: 10px 22px;
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    border: none;
    font-weight: bold;
    color: #fff;
}

.btn-link {
    color: #bbb;
}

.btn-link:hover {
    color: #ffffff;
}

    </style>
</head>
<body>
<div class="glass-card">
    <h3>📝 Create New Blog Post</h3>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" placeholder="Enter blog title" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" placeholder="Optional subtitle">
        </div>

        <div class="mb-3">
            <label class="form-label">Content <span class="text-danger">*</span></label>
            <textarea name="content" rows="6" class="form-control" placeholder="Write your blog content..." required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Image URL</label>
            <input type="text" name="image_url" class="form-control" placeholder="https://example.com/image.jpg">
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">🚀 Post Blog</button>
            <a href="dashboard.php" class="btn btn-link text-decoration-none">← Back to Dashboard</a>
        </div>
    </form>
</div>
</body>
</html>

