<?php
session_start(); // Start session to access logged-in user data
include './includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['property_id'])) {
    $property_id = intval($_POST['property_id']);

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID
    } else {
        echo "Error: User not logged in.";
        exit;
    }

    // Retrieve property details for confirmation display
    $query = "SELECT title, price, location,image  FROM properties WHERE property_id = $property_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $property = $result->fetch_assoc();

        // Insert purchase request into purchase_requests table
        $insertQuery = "INSERT INTO purchase_requests (property_id, user_id, request_date) VALUES ($property_id, $user_id, NOW())";
        $conn->query($insertQuery);
    } else {
        echo "Error: Property not found.";
        exit;
    }
} else {
    echo "No property selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>buy-property.php</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        /* Reset some default styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.confirmation {
    width: 60%;
    margin-top: 50px;
    padding: 25px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.confirmation-content h2 {
    font-size: 28px;
    color: #4CAF50;
    margin-bottom: 20px;
}

.confirmation-content p {
    font-size: 18px;
    margin: 10px 0;
    line-height: 1.6;
}

.property-summary {
    margin: 25px 0;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f8f8f8;
    text-align: left;
    position: relative;
}

.property-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

.property-summary p {
    margin: 8px 0;
    font-size: 16px;
    color: #555;
}

.property-summary p strong {
    color: #333;
}


.back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 25px;
    font-size: 16px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.3s;
}

.back-btn:hover {
    background-color: #45a049;
}

@media (max-width: 768px) {
    .confirmation {
        width: 90%;
    }

    .confirmation-content h2 {
        font-size: 24px;
    }

    .property-summary p {
        font-size: 15px;
    }
}

    </style>

<section class="confirmation">
    <div class="confirmation-content">
        <h2>Thank You for Your Interest!</h2>
        <p>You have expressed interest in purchasing the property:</p>
        <div class="property-summary">
            <img src="./images/<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>" class="property-image">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($property['title']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($property['price'], 2)); ?></p>
        </div>
        <p>Our sales agent will reach out to you soon with more details.</p>
        <a href="home.php" class="back-btn">Back to Listings</a>
    </div>
</section>

</body>
</html>