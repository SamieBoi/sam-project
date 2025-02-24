<?php
session_start();
include '../includes/db_connect.php';

// Assuming the agent's user ID is stored in the session upon login
$agent_id = $_SESSION['user_id']; // Ensure to set this during agent login

$query = "SELECT * FROM properties WHERE added_by = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $agent_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add-agent-dashboard.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <style>
        /* General Container Styling */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Form Styling */
form {
    display: flex;
    flex-direction: column;
}

label {
    margin: 10px 0 5px;
}

input {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button {
    margin-top: 10px;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

button:hover {
    background-color: #0056b3;
}

/* Data Table Styling */
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.data-table thead {
    background-color: #007bff;
    color: #fff;
}

.data-table th, .data-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.data-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.data-table tr:hover {
    background-color: #f1f1f1;
}

/* Responsive Table */
@media (max-width: 768px) {
    .data-table, .data-table thead, .data-table tbody, .data-table th, .data-table td, .data-table tr {
        display: block;
    }

    .data-table tr {
        margin-bottom: 15px;
    }

    .data-table th, .data-table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    .data-table th::before, .data-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 45%;
        padding-left: 10px;
        font-weight: bold;
        text-align: left;
    }
}

/* Button Styles */
.edit-btn {
    background-color: #ffc107;
    color: #fff;
    padding: 6px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.edit-btn:hover {
    background-color: #e0a800;
}

.delete-btn {
    background-color: #e74c3c;
    color: #fff;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
}

.delete-btn:hover {
    background-color: #c0392b;
}

    </style>
    <div class="container">
        <h2>Welcome, Agent!</h2>
        <a href="../admin/add-property.php" class="btn">Add New Property</a>
        <h3>Your Properties</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['property_id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="edit-property.php?id=<?php echo $row['property_id']; ?>" class="edit-btn">Edit</a>
                            <form action="delete-property.php" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                <input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>