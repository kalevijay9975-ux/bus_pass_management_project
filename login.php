<?php
session_start();
require_once "config.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin["password"])) {
        $_SESSION["user_id"] = $admin["id"];
        $_SESSION["username"] = $admin["username"];
        header("Location: dashboard.php");
        exit;
    }
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="page-center">
<div class="card form-card">
<h2>Admin Login</h2>
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<label>Username</label>
<input type="text" name="username" required autofocus>
<label>Password</label>
<input type="password" name="password" required>
<button class="btn" type="submit">Login</button>
</form>
<p class="muted">Default: admin / admin123</p>
<a href="index.php">← Back to home</a>
</div>
</div>
</body>
</html>
