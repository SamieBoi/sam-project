<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: agent-login.php");
    exit();
}

// Fetch property details for editing
if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    $sql = "SELECT * FROM properties WHERE property_id = ? AND added_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $property_id, $_SESSION['user_id']);
    $stmt->execute();
    $property = $stmt->get_result()->fetch_assoc();
}

// Handle form submission
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
    $amenities = json_encode($_POST['amenities']);

    // Handle image upload if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target = "../assets/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $image_field = ", image = '$image'";
    } else {
        $image_field = '';
    }

    $sql = "UPDATE properties SET title = ?, description = ?, price = ?, location = ?, property_type = ?, bedrooms = ?, bathrooms = ?, square_footage = ?, year_built = ?, status = ?, amenities = ? $image_field WHERE property_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssiiisiis", $title, $description, $price, $location, $property_type, $bedrooms, $bathrooms, $square_footage, $year_built, $status, $amenities, $property_id);

    if ($stmt->execute()) {
        echo "Property updated successfully!";
        header("Location: view-properties.php");
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
    <title>edit-properties.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Property</h2>
        <form action="edit-property.php?id=<?php echo $property['property_id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($property['description']); ?></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>

            <label for="property_type">Property Type</label>
            <select id="property_type" name="property_type" required>
                <option value="Apartment" <?php if ($property['property_type'] == 'Apartment') echo 'selected'; ?>>Apartment</option>
                <option value="House" <?php if ($property['property_type'] == 'House') echo 'selected'; ?>>House</option>
                <option value="Office" <?php if ($property['property_type'] == 'Office') echo 'selected'; ?>>Office</option>
                <option value="Land" <?php if ($property['property_type'] == 'Land') echo 'selected'; ?>>Land</option>
            </select>

            <label for="bedrooms">Bedrooms</label>
            <input type="number" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required>

            <label for="bathrooms">Bathrooms</label>
            <input type="number" id="bathrooms" name="bathrooms" value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required>

            <label for="square_footage">Square Footage</label>
            <input type="number" id="square_footage" name="square_footage" value="<?php echo htmlspecialchars($property['square_footage']); ?>" required>

            <label for="year_built">Year Built</label>
            <input type="number" id="year_built" name="year_built" value="<?php echo htmlspecialchars($property['year_built']); ?>" required>

            <label for="status">Property Status</label>
            <select id="status" name="status" required>
                <option value="For Sale" <?php if ($property['status'] == 'For Sale') echo 'selected'; ?>>For Sale</option>
                <option value="For Rent" <?php if ($property['status'] == 'For Rent') echo 'selected'; ?>>For Rent</option>
            </select>

            <label for="amenities">Amenities</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="amenities[]" value="Pool" <?php if (in_array('Pool', json_decode($property['amenities'], true))) echo 'checked'; ?>> Pool</label>
                <label><input type="checkbox" name="amenities[]" value="Garage" <?php if (in_array('Garage', json_decode($property['amenities'], true))) echo 'checked'; ?>> Garage</label>
                <label><input type="checkbox" name="amenities[]" value="Gym" <?php if (in_array('Gym', json_decode($property['amenities'], true))) echo 'checked'; ?>> Gym</label>
                <label><input type="checkbox" name="amenities[]" value="Garden" <?php if (in_array('Garden', json_decode($property['amenities'], true))) echo 'checked'; ?>> Garden</label>
            </div>

            <label for="image">New Image (optional)</label>
            <input type="file" id="image" name="image">

            <button type="submit">Update Property</button>
        </form>
    </div>
</body>
</html>