<?php
session_start();
include '../includes/db_connect.php';

// Fetch inquiries for the logged-in agent
$sql = "SELECT * FROM inquiries";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view-inquiries.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
        <h2>Inquiries</h2>
        <table>
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['property_id']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['user_email']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>