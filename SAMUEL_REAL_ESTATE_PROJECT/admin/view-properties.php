<?php
include '../includes/db_connect.php';

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view-properties.php</title>
    <link rel="stylesheet" href="./property.css">
    <style>
        /* Reset and Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #343a40;
            font-size: 28px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            max-width: 100px; /* Set a maximum width for images */
            height: auto;
            border-radius: 5px; /* Round the corners of images */
        }

        .action-links {
            display: flex;
            justify-content: space-around;
        }

        .action-links a {
            margin: 0 5px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .action-links a:hover {
            color: #0056b3; /* Darker blue on hover */
        }

        @media (max-width: 600px) {
            th, td {
                padding: 10px; /* Less padding on small screens */
                font-size: 14px; /* Smaller font size */
            }

            img {
                max-width: 80px; /* Smaller images on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Properties</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Bedrooms</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>"></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo number_format($row['price'], 2); ?> USD</td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['property_type']; ?></td>
                        <td><?php echo $row['bedrooms']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td class="action-links">
                            <a href="edit-property.php?property_id=<?php echo $row['property_id']; ?>">Edit</a> |
                            <a href="delete-property.php?property_id=<?php echo $row['property_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>