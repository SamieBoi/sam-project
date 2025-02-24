<?php
include '../includes/db_connect.php';

if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];

    // Fetch existing property data
    $sql = "SELECT * FROM properties WHERE property_id = '$property_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $property = $result->fetch_assoc();
    } else {
        echo "Property not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated data from form
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
    $target = "../images/" . basename($image);
    $imageUpdated = false;

    if ($image) {
        // If a new image is uploaded, update the image file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imageUpdated = true;
        } else {
            echo "Failed to upload image.";
        }
    }

    // Prepare the update query
    $sql = "UPDATE properties SET
                title = '$title',
                description = '$description',
                price = '$price',
                location = '$location',
                property_type = '$property_type',
                bedrooms = '$bedrooms',
                bathrooms = '$bathrooms',
                square_footage = '$square_footage',
                year_built = '$year_built',
                status = '$status',
                amenities = '$amenities'". ($imageUpdated ? ", image = '$image'" : "") ."
            WHERE property_id = '$property_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Property updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit-property.php</title>
    <link rel="stylesheet" href="./property.css">
</head>
<body>
    <div class="container">
        <h2>Edit Property</h2>
        <form action="edit-property.php?property_id=<?php echo $property_id; ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($property['description']); ?></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo $property['price']; ?>" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>

            <label for="property_type">Property Type</label>
            <select id="property_type" name="property_type" required>
                <option value="Apartment" <?php echo $property['property_type'] == 'Apartment' ? 'selected' : ''; ?>>Apartment</option>
                <option value="House" <?php echo $property['property_type'] == 'House' ? 'selected' : ''; ?>>House</option>
                <option value="Office" <?php echo $property['property_type'] == 'Office' ? 'selected' : ''; ?>>Office</option>
                <option value="Land" <?php echo $property['property_type'] == 'Land' ? 'selected' : ''; ?>>Land</option>
            </select>

            <label for="bedrooms">Bedrooms</label>
            <input type="number" id="bedrooms" name="bedrooms" value="<?php echo $property['bedrooms']; ?>" required>

            <label for="bathrooms">Bathrooms</label>
            <input type="number" id="bathrooms" name="bathrooms" value="<?php echo $property['bathrooms']; ?>" required>

            <label for="square_footage">Square Footage</label>
            <input type="number" id="square_footage" name="square_footage" value="<?php echo $property['square_footage']; ?>" required>

            <label for="year_built">Year Built</label>
            <input type="number" id="year_built" name="year_built" value="<?php echo $property['year_built']; ?>" required>

            <label for="status">Property Status</label>
            <select id="status" name="status" required>
                <option value="For Sale" <?php echo $property['status'] == 'For Sale' ? 'selected' : ''; ?>>For Sale</option>
                <option value="For Rent" <?php echo $property['status'] == 'For Rent' ? 'selected' : ''; ?>>For Rent</option>
            </select>

            <label for="amenities">Amenities</label>
            <div class="checkbox-group">
                <?php
                // Decode the JSON to get the amenities
                $existingAmenities = json_decode($property['amenities'], true);
                $amenitiesOptions = ['Pool', 'Garage', 'Gym', 'Garden'];
                foreach ($amenitiesOptions as $amenity) {
                    $checked = in_array($amenity, $existingAmenities) ? 'checked' : '';
                    echo "<label><input type='checkbox' name='amenities[]' value='$amenity' $checked> $amenity</label>";
                }
                ?>
            </div>

            <label for="image">Image</label>
            <input type="file" id="image" name="image">

            <button type="submit">Update Property</button>
        </form>
    </div>
</body>
</html>