<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $property_id = $_POST['property_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO inquiries (property_id, user_name, user_email, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $property_id, $user_name, $user_email, $message);

    if ($stmt->execute()) {
        echo "Inquiry submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>submit-inquiry.php</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <style>
        table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

@media screen and (max-width: 600px) {
    .container {
        width: 100%;
    }

    table, th, td {
        display: block;
    }

    th {
        display: none;
    }

    td {
        border: none;
        position: relative;
        padding-left: 50%;
    }

    td:before {
        position: absolute;
        left: 10px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
    }

    td:nth-of-type(1):before { content: "Property ID"; }
    td:nth-of-type(2):before { content: "Name"; }
    td:nth-of-type(3):before { content: "Email"; }
    td:nth-of-type(4):before { content: "Message"; }
}

    </style>
    <div class="container">
        <h2>Submit Inquiry</h2>
        <form action="submit-inquiry.php" method="POST">
            <label for="property_id">Property ID</label>
            <input type="number" id="property_id" name="property_id" required>

            <label for="user_name">Your Name</label>
            <input type="text" id="user_name" name="user_name" required>

            <label for="user_email">Your Email</label>
            <input type="email" id="user_email" name="user_email" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Submit Inquiry</button>
        </form>
    </div>
</body>
</html>