<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $report_id = $_POST['report_id'];
    $delete_query = "DELETE FROM reports WHERE report_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT reports.*, users.username, properties.title AS property_title
          FROM reports
          JOIN users ON reports.user_id = users.id
          JOIN properties ON reports.property_id = properties.property_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
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

button.delete-btn {
    background-color: #e74c3c;
    color: #fff;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

button.delete-btn:hover {
    background-color: #c0392b;
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

    </style>
    <div class="container">
        <h2>view-reports.php</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>User</th>
                    <th>Property</th>
                    <th>Reason</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['report_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['property_title']; ?></td>
                        <td><?php echo $row['report_reason']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <form action="view-reports.php" method="POST" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                                <button type="submit" name="delete" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>