<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: agent-login.php");
    exit();
}

// Fetch properties added by the agent
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM properties WHERE added_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view-properties.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Your Properties</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($property = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($property['title']); ?></td>
                    <td><?php echo htmlspecialchars($property['price']); ?></td>
                    <td><?php echo htmlspecialchars($property['location']); ?></td>
                    <td><?php echo htmlspecialchars($property['status']); ?></td>
                    <td>
                        <a href="edit-property.php?id=<?php echo $property['property_id']; ?>">Edit</a>
                        <a href="delete-property.php?id=<?php echo $property['property_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="add-property.php" class="btn">Add New Property</a>
    </div>
</body>
</html>