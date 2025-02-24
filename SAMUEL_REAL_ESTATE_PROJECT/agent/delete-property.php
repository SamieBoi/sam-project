<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: agent-login.php");
    exit();
}

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    $sql = "DELETE FROM properties WHERE property_id = ? AND added_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $property_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "Property deleted successfully!";
        header("Location: view-properties.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>