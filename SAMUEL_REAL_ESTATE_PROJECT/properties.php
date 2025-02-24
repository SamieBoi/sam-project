<?php
session_start();
include './includes/db_connect.php';

// Fetch all properties from the database
$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>properties.php</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        .properties-section {
    padding: 40px;
    background-color: #f9f9f9;
}

.properties-container {
    max-width: 1200px;
    margin: 0 auto;
}

.properties-container h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 36px;
    color: #333;
}

.property-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.property-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin: 15px;
    padding: 15px;
    width: calc(30% - 30px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.property-card:hover {
    transform: translateY(-5px);
}

.property-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.property-card h3 {
    font-size: 20px;
    margin: 10px 0;
}

.property-card p {
    margin: 5px 0;
    font-size: 14px;
}

.view-details-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: orange;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.view-details-btn:hover {
    background-color: #45a049;
}

@media (max-width: 768px) {
    .property-card {
        width: calc(45% - 30px);
    }
}

@media (max-width: 480px) {
    .property-card {
        width: 100%;
    }
}

    </style>
    <?php
// session_start();
include './includes/navbar.php';
 ?>

<section class="properties-section">
    <div class="properties-container">
        <h1>Available Properties</h1>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="property-list">
                <?php while ($property = $result->fetch_assoc()): ?>
                    <div class="property-card">
                        <img src="./images/<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>" class="property-image">
                        <h3><?php echo htmlspecialchars($property['title']); ?></h3>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
                        <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($property['price'], 2)); ?></p>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($property['property_type']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($property['status']); ?></p>
                        <a href="property-detail.php?id=<?php echo $property['property_id']; ?>" class="view-details-btn">View Details</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No properties available at the moment.</p>
        <?php endif; ?>
    </div>
</section>
<?php

include './includes/footer.php';
 ?>
</body>
</html>