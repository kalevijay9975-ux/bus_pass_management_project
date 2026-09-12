<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$countResult = $conn->query("SELECT COUNT(*) AS total FROM bus_passes");
$total = $countResult ? (int)$countResult->fetch_assoc()["total"] : 0;

$result = $conn->query("SELECT * FROM bus_passes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar">
    <strong>Bus Pass Management</strong>
    <span>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?> |
        <a href="logout.php">Logout</a>
    </span>
</nav>
<div class="container">
    <div class="topbar">
        <div>
            <h1>Dashboard</h1>
            <p class="muted">Total bus passes: <strong><?= $total ?></strong></p>
        </div>
        <a class="btn" href="add_pass.php">+ Add Bus Pass</a>
    </div>

    <?php if (isset($_GET["success"])): ?>
        <div class="alert success">Operation completed successfully.</div>
    <?php endif; ?>

    <div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Passenger</th><th>Email</th><th>Phone</th>
                <th>Route</th><th>Pass Type</th><th>Valid Until</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= (int)$row["id"] ?></td>
                <td><?= htmlspecialchars($row["passenger_name"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td><?= htmlspecialchars($row["phone"]) ?></td>
                <td><?= htmlspecialchars($row["route"]) ?></td>
                <td><?= htmlspecialchars($row["pass_type"]) ?></td>
                <td><?= htmlspecialchars($row["valid_until"]) ?></td>
                <td class="actions">
                    <a href="edit_pass.php?id=<?= (int)$row["id"] ?>">Edit</a>
                    <a class="danger-link" href="delete_pass.php?id=<?= (int)$row["id"] ?>"
                       onclick="return confirm('Delete this bus pass?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" class="center">No bus passes found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
