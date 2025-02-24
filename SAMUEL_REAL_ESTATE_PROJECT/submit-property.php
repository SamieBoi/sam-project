<?php
include './includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $property_type = $_POST['property_type'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $square_footage = $_POST['square_footage'];
    $year_built = $_POST['year_built'];
    $status = $_POST['status'];

    // Store amenities as a variable
    $amenitiesArray = isset($_POST['amenities']) ? $_POST['amenities'] : [];
    $amenities = json_encode($amenitiesArray); // Convert to JSON

    $image = $_FILES['image']['name'];
    $target = "./images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Create SQL query
        $sql = "INSERT INTO properties
            (title, description, price, location, property_type, bedrooms, bathrooms, square_footage, year_built, status, amenities, image, added_by)
            VALUES ('$title', '$description', '$price', '$location', '$property_type', '$bedrooms', '$bathrooms', '$square_footage', '$year_built', '$status', '$amenities', '$image', 1)";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
        
            echo "<script>alert('Property added successfully!')</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>submit-property.php</title>
    <link rel="stylesheet" href="./admin/property.css">
</head>
<body>
<?php
session_start();

include './includes/navbar.php';
 ?>
    <div class="container">
        <h2>Add New Property</h2>
        <form action="#" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>

            <label for="property_type">Property Type</label>
            <select id="property_type" name="property_type" required>
                <option value="Apartment">Apartment</option>
                <option value="House">House</option>
                <option value="Office">Office</option>
                <option value="Land">Land</option>
            </select>

            <label for="bedrooms">Bedrooms</label>
            <input type="number" id="bedrooms" name="bedrooms" required>

            <label for="bathrooms">Bathrooms</label>
            <input type="number" id="bathrooms" name="bathrooms" required>

            <label for="square_footage">Square Footage</label>
            <input type="number" id="square_footage" name="square_footage" required>

            <label for="year_built">Year Built</label>
            <input type="number" id="year_built" name="year_built" required>

            <label for="status">Property Status</label>
            <select id="status" name="status" required>
                <option value="For Sale">For Sale</option>
                <option value="For Rent">For Rent</option>
            </select>

            <label for="amenities">Amenities</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="amenities[]" value="Pool"> Pool</label>
                <label><input type="checkbox" name="amenities[]" value="Garage"> Garage</label>
                <label><input type="checkbox" name="amenities[]" value="Gym"> Gym</label>
                <label><input type="checkbox" name="amenities[]" value="Garden"> Garden</label>
            </div>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" required>

            <button type="submit">Add Property</button>
        </form>
    </div>

    <?php
// session_start();
include './includes/footer.php';
 ?>
</body>
</html>