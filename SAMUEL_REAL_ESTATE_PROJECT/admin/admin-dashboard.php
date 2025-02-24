<?php
session_start();
// Include your database connection
include '../includes/db_connect.php';

// Fetch necessary data for dashboard overview
$totalProperties = $conn->query("SELECT COUNT(*) AS count FROM properties")->fetch_assoc()['count'];
$totalAgents = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'agent'")->fetch_assoc()['count'];
$newInquiries = $conn->query("SELECT COUNT(*) AS count FROM inquiries WHERE status = 'new'")->fetch_assoc()['count'];

// Fetch recent activities
$recentActivitiesQuery = "SELECT activity, timestamp FROM activities ORDER BY timestamp DESC LIMIT 5"; // Adjust the limit as needed
$recentActivitiesResult = $conn->query($recentActivitiesQuery);
$recentActivities = [];

if ($recentActivitiesResult->num_rows > 0) {
    while ($row = $recentActivitiesResult->fetch_assoc()) {
        $recentActivities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin-dashboard.php</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>

        <!-- Dashboard Stats Overview -->
        <div class="dashboard-stats">
            <div class="card">
                <h3>Total Properties</h3>
                <p><?php echo $totalProperties; ?></p>
            </div>
            <div class="card">
                <h3>Total Agents</h3>
                <p><?php echo $totalAgents; ?></p>
            </div>
            <div class="card">
                <h3>New Inquiries</h3>
                <p><?php echo $newInquiries; ?></p>
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="recent-activities">
            <h2>Recent Activities</h2>
            <ul>
                <?php
                // Display recent activities
                if (!empty($recentActivities)) {
                    foreach ($recentActivities as $activity) {
                        // Format the timestamp as needed
                        $formattedTime = date('F j, Y, g:i a', strtotime($activity['timestamp']));
                        echo "<li>{$activity['activity']} - {$formattedTime}</li>";
                    }
                } else {
                    echo "<li>No recent activities found.</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Navigation Links -->
        <div class="admin-actions">
            <a href="add-property.php" class="action-btn">Add New Property</a>
            <a href="view-properties.php" class="action-btn">View All Properties</a>
            <a href="manage-user.php" class="action-btn">Manage Users</a>
            <a href="view-reports.php" class="action-btn">View Reports</a>
        </div>
    </div>
</body>
</html>