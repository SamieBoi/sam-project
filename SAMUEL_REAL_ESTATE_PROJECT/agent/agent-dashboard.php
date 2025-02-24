<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: agent-login.php");
    exit();
}

// Fetch agent-related data
$user_id = $_SESSION['user_id'];
$sql_properties = "SELECT COUNT(*) AS total_properties FROM properties WHERE added_at = ?";
$sql_inquiries = "SELECT COUNT(*) AS total_inquiries FROM inquiries WHERE property_id IN (SELECT property_id FROM properties WHERE added_at = ?)";

$stmt = $conn->prepare($sql_properties);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_properties = $stmt->get_result();
$total_properties = $result_properties->fetch_assoc()['total_properties'];

$stmt = $conn->prepare($sql_inquiries);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_inquiries = $stmt->get_result();
$total_inquiries = $result_inquiries->fetch_assoc()['total_inquiries'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agent-dashboard.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <style>
        .dashboard {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.card {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    width: 30%;
    text-align: center;
}

.card h3 {
    margin: 0;
}

.btn {
    display: inline-block;
    margin: 20px 5px;
    padding: 10px 20px;
    background-color: #5cb85c;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background-color: #4cae4c;
}

    </style>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <div class="dashboard">
            <div class="card">
                <h3>Total Properties</h3>
                <p><?php echo $total_properties; ?></p>
            </div>
            <div class="card">
                <h3>Total Inquiries</h3>
                <p><?php echo $total_inquiries; ?></p>
            </div>
        </div>
        <a href="submit-inquiry.php" class="btn">Submit Inquiry</a>
        <a href="view-inquiries.php" class="btn">View Inquiries</a>
    </div>
</body>
</html>