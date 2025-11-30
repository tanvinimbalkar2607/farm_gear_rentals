<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Validate Equipment ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Equipment ID is missing!");
}

$equipment_id = intval($_GET['id']); // Convert ID to integer for security

// Use Prepared Statement to prevent SQL Injection
$sql = "DELETE FROM equipment WHERE equipment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $equipment_id);

if ($stmt->execute()) {
    header("Location: admin_dashboard.php?msg=Equipment Deleted Successfully");
    exit();
} else {
    echo "Error deleting equipment: " . $conn->error;
}
?>
