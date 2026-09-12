<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET["id"] ?? 0);
$stmt = $conn->prepare("SELECT * FROM bus_passes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$pass = $stmt->get_result()->fetch_assoc();

if (!$pass) {
    die("Bus pass not found.");
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
    } else {
        $stmt = $conn->prepare(
            "UPDATE bus_passes SET passenger_name=?, email=?, phone=?, route=?, pass_type=?, valid_until=?
             WHERE id=?"
        );
        $stmt->bind_param("ssssssi", $name, $email, $phone, $route, $pass_type, $valid_until, $id);
        if ($stmt->execute()) {
            header("Location: dashboard.php?success=1");
            exit;
        }
        $error = "Unable to update bus pass.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Bus Pass</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="page-center">
<div class="card form-card wide">
<h2>Edit Bus Pass</h2>
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<label>Passenger Name</label><input name="passenger_name" value="<?= htmlspecialchars($pass["passenger_name"]) ?>" required>
<label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($pass["email"]) ?>" required>
<label>Phone</label><input name="phone" value="<?= htmlspecialchars($pass["phone"]) ?>" required>
<label>Route</label><input name="route" value="<?= htmlspecialchars($pass["route"]) ?>" required>
<label>Pass Type</label>
<select name="pass_type" required>
<?php foreach (["Daily","Weekly","Monthly","Quarterly"] as $type): ?>
<option <?= $pass["pass_type"] === $type ? "selected" : "" ?>><?= $type ?></option>
<?php endforeach; ?>
</select>
<label>Valid Until</label><input type="date" name="valid_until" value="<?= htmlspecialchars($pass["valid_until"]) ?>" required>
<button class="btn" type="submit">Update Pass</button>
<a class="btn secondary" href="dashboard.php">Cancel</a>
</form>
</div>
</div>
</body>
</html>
