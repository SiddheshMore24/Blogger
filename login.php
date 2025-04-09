<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($role === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM reader WHERE email = ?");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            if ($role === 'admin') {
                $_SESSION['admin_id'] = $user['id'];
                // $_SESSION['admin_id'] = $admin_id;
                $_SESSION['username'] = $user['username'];

                header("Location: dashboard.php");
            } else {
                $_SESSION['reader_id'] = $user['id'];
                header("Location: reader.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fix dropdown background and text color */
.form-select {
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff;
}

.form-select option {
    background-color: #222; /* dark dropdown menu */
    color: #fff;
}

/* Input focus border + placeholder color */
.form-control:focus,
.form-select:focus {
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    border-color: #28a745;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-control::placeholder {
    color: #ddd;
}

/* Improve the 'New here?' link */
.text-center a {
    color: #90ee90;
    font-weight: 500;
}

.text-center a:hover {
    color: #b6fcb6;
    text-decoration: none;
}

    body {
        background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?fit=crop&w=1920&q=80'); /* Blogging theme */
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Dark overlay */
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }

    .form-label, .form-control, .form-select {
        color: white !important;
    }

    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 12px;
    }

    .form-control::placeholder {
        color: #eee;
    }

    .btn-primary {
        background-color: #28a745;
        border: none;
        border-radius: 12px;
        padding: 10px;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #218838;
    }

    a {
        color: #f0f0f0;
        text-decoration: underline;
    }

    h3 {
        color: #fff;
    }

    .alert-danger {
        background-color: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
    }
</style>


</head>
<body>

<div class="container">
    <div class="col-md-6 offset-md-3">
        <div class="glass-card">
            <h3 class="text-center mb-4">Login</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Login as:</label>
                    <select name="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="reader">Reader</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-4" style="color: #ccc; font-size: 0.95rem;">
    <span style="opacity: 0.9;">New here?</span> 
    <a href="signup.php" style="color: #90ee90; text-decoration: underline; font-weight: 500;">
        Create an account
    </a>
</p>

        </div>
    </div>
</div>

</body>
</html>
