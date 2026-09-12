<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET["id"] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM bus_passes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: dashboard.php?success=1");
exit;
?>
