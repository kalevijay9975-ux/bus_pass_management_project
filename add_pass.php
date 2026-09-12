<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["passenger_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $route = trim($_POST["route"] ?? "");
    $pass_type = trim($_POST["pass_type"] ?? "");
    $valid_until = $_POST["valid_until"] ?? "";

    if (!$name || !$email || !$phone || !$route || !$pass_type || !$valid_until) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO bus_passes (passenger_name,email,phone,route,pass_type,valid_until)
             VALUES (?,?,?,?,?,?)"
        );
        $stmt->bind_param("ssssss", $name, $email, $phone, $route, $pass_type, $valid_until);
        if ($stmt->execute()) {
            header("Location: dashboard.php?success=1");
            exit;
        }
        $error = "Unable to add bus pass.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Bus Pass</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="page-center">
<div class="card form-card wide">
<h2>Add Bus Pass</h2>
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<label>Passenger Name</label><input name="passenger_name" required>
<label>Email</label><input type="email" name="email" required>
<label>Phone</label><input name="phone" required>
<label>Route</label><input name="route" placeholder="e.g. Pune to Mumbai" required>
<label>Pass Type</label>
<select name="pass_type" required>
    <option value="">Select type</option>
    <option>Daily</option><option>Weekly</option><option>Monthly</option><option>Quarterly</option>
</select>
<label>Valid Until</label><input type="date" name="valid_until" required>
<button class="btn" type="submit">Save Pass</button>
<a class="btn secondary" href="dashboard.php">Cancel</a>
</form>
</div>
</div>
</body>
</html>
