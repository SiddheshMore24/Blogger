<?php
require 'db.php';

$feedback = null;
$roleName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkStmt = $conn->prepare(
        $role === 'admin' 
        ? "SELECT id FROM admin WHERE email = ?" 
        : "SELECT id FROM reader WHERE email = ?"
    );
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $feedback = "exists";
    } else {
        // Insert user
        $stmt = $conn->prepare(
            $role === 'admin' 
            ? "INSERT INTO admin (username, email, password_hash) VALUES (?, ?, ?)" 
            : "INSERT INTO reader (username, email, password_hash) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $feedback = "success";
            $roleName = ucfirst($role);
        } else {
            $feedback = "error";
        }

        $stmt->close();
    }

    $checkStmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .card {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(14px);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
            padding: 35px;
            color: #fff;
        }

        .form-label {
            font-weight: 600;
            color: #f0f0f0;
        }

        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 10px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-color: #0d6efd;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .link-text {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        .link-text:hover {
            color: #69a7ff;
        }

        .form-title {
            font-weight: 700;
            color: #fff;
        }

        select option {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow-lg">
            <div class="card-body">
                <h3 class="text-center mb-4 form-title">Signup</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Signup as:</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="reader">Reader</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required placeholder="Enter your name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Create a password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>
                <p class="text-center mt-3">Already have an account? 
                    <a href="login.php" class="link-text">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Feedback Modal -->
<?php if ($feedback === 'success'): ?>
    <div class="modal fade show" id="feedbackModal" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title w-100">🎉 Account Created</h5>
                </div>
                <div class="modal-body">
                    <p><strong><?= $roleName ?></strong> registered successfully!</p>
                    <p>Redirecting to login page...</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <script>
        setTimeout(() => {
            window.location.href = "login.php";
        }, 3000);
    </script>

<?php elseif ($feedback === 'exists'): ?>
    <div class="modal fade show" id="feedbackModal" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center bg-danger text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title w-100">⚠️ User Already Exists</h5>
                </div>
                <div class="modal-body">
                    <p>An account with this email already exists.</p>
                    <p>Please <a href="login.php" class="link-light fw-bold">Login here</a> or try another email.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
