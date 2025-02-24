<?php
include './includes/db_connect.php';

// Fetch property details by ID
if (isset($_GET['id'])) {
    $property_id = intval($_GET['id']);
    $query = "SELECT * FROM properties WHERE property_id = $property_id";
    $result = $conn->query($query);
    $property = $result->fetch_assoc();
} else {
    echo "No property ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($property['title']); ?> - property-detail.php</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
}
.property-details{
    /* border:2px solid red; */
    padding: 3% 2rem;
    color:white;
    background-color: orange;

}
.property-inside{
    display:flex;
    justify-content: space-between;
}
.property-title{
    display:flex;
    flex-direction:column;
}
.property-title h2{
    font-size:50px;
    font-weight:900;
}
.property-image #img{
    width: 18px;
    height:18px;
}
.property-list{
    display:flex;
    justify-content: space-between;


}
.property-list p{
    align-items:center;
}
.how-to{
    padding: 3% 2rem;

}
.buy-now-btn{
    color:orange;
}
    </style>
     <?php
    session_start();

include './includes/navbar.php';
 ?>

    <section class="property-details">
        <div class="property-header">
            <div class="property-inside">
                <div class="property-title">
        <p><strong>Property Type:</strong> <?php echo htmlspecialchars($property['property_type']); ?></p>

        <h2><?php echo htmlspecialchars($property['title']); ?></h2>

        <p><strong>Description:</strong> <?php echo htmlspecialchars($property['description']); ?></p>
        <div class="property-list">
        <p><strong>Square Footage</strong> <br> <?php echo htmlspecialchars($property['square_footage']); ?> sqft</p>
        <p><strong>Bedrooms</strong> <br> <?php echo htmlspecialchars($property['bedrooms']); ?></p>
        <p><strong>Bathrooms</strong> <br> <?php echo htmlspecialchars($property['bathrooms']); ?></p>
        <p><strong>Year Built</strong> <br> <?php echo htmlspecialchars($property['year_built']); ?></p>
        <p><strong>Status</strong> <br> <?php echo htmlspecialchars($property['status']); ?></p>
        </div>
        </div>
<div class="property-image">
<img src="./images/<?php echo $property['image']; ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
<p class="location"><img id="img"src="./img/WhatsApp Image 2024-11-02 at 03.53.33_a6c84b3c.jpg" alt=""> <?php echo htmlspecialchars($property['location']); ?></p>

</div>
    </div>
        </div>
    </section>

<section class="how-to">
    <div class="how-to-buy">
        <h3>How to Buy or Rent This Property</h3>
        <p>If interested, follow these steps:</p>
        <ol>
            <li>Contact our agent at <strong>(234) 8025935464</strong> or <strong>olamidipuposamuel142@gmail.com</strong>.</li>
            <li>Arrange a viewing to inspect the property in person.</li>
            <li>Submit an offer, and our team will assist with paperwork and formalities.</li>
            <li>Finalize the transaction with our support for financing and legal steps.</li>
        </ol>
        <form action="buy-property.php" method="POST">
            <input type="hidden" name="property_id" value="<?php echo $property['property_id']; ?>">
            <button type="submit" class="buy-now-btn">Buy Now</button>
        </form>
    </div>
</section>
<?php
    // session_start();

include './includes/footer.php';
 ?>
</body>
</html>