<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bus Pass Management</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="hero">
    <div class="card center">
        <h1>Bus Pass Management System</h1>
        <p>Simple PHP + MySQL application ready for AWS EC2 deployment.</p>
        <a class="btn" href="login.php">Admin Login</a>
    </div>
</div>
</body>
</html>
