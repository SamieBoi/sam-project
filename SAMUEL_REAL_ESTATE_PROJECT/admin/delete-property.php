<?php
include '../includes/db_connect.php';

if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];

    // Prepare the delete query
    $sql = "DELETE FROM properties WHERE property_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $property_id);

    if ($stmt->execute()) {
        // Redirect back to the view properties page after deletion
        header("Location: view-properties.php?message=Property deleted successfully!");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}

$conn->close();