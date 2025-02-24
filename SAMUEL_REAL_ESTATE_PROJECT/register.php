<?php
include './includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, city, country, username, email, password, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssss", $first_name, $last_name, $city, $country, $username, $email, $password, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now log in.')</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register.php User Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <style>
      /* Reset and Base Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern sans-serif font */
}

body {
    background-color: #e9ecef; /* Soft background color */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    width: 100%;
    max-width: 600px; /* Wider container for horizontal layout */
    background-color: #ffffff;
    padding: 30px; /* Padding for spacious feel */
    border-radius: 15px; /* Rounder corners */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #343a40; /* Darker heading color */
    font-size: 28px; /* Larger font size */
    font-weight: 700; /* Bolder font weight */
}

.form-row {
    display: flex; /* Horizontal layout for form rows */
    justify-content: space-between; /* Space between form groups */
    margin-bottom: 15px; /* Spacing between rows */
}

.form-group {
    flex: 1; /* Allow form groups to grow equally */
    margin-right: 10px; /* Spacing between columns */
}

.form-group:last-child {
    margin-right: 0; /* Remove right margin from last element */
}

label {
    display: block;
    font-size: 15px; /* Slightly larger font size */
    margin-bottom: 5px; /* Space below label */
    text-align: left;
    color: #495057; /* Soft gray for text */
}

input[type="text"],
input[type="password"],
input[type="email"],
input[type="tel"],
input[type="tel"],
select {
    width: 100%; /* Full width inputs */
    padding: 12px; /* Comfortable padding */
    border: 1px solid #ced4da; /* Light gray border */
    border-radius: 10px; /* Rounder corners for inputs */
    transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transition */
}

input:focus,
select:focus {
    border-color: #007bff; /* Bright blue on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Shadow effect */
    outline: none; /* Remove default outline */
}

button {
    width: 100%;
    padding: 15px;
    margin-top: 20px;
    background-color: #007bff; /* Bright blue for button */
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 10px; /* Rounder corners for buttons */
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s; /* Smooth transition */
}

button:hover {
    background-color: #0056b3; /* Darker blue on hover */
    transform: translateY(-2px); /* Lift effect on hover */
}

p {
    margin-top: 20px;
    font-size: 14px;
    color: #6c757d; /* Softer gray for text */
}

a {
    color: #007bff; /* Bright blue for links */
    text-decoration: none;
}

a:hover {
    text-decoration: underline; /* Underline on hover */
}

@media (max-width: 600px) {
    .container {
        width: 90%; /* Responsive width */
        padding: 20px; /* Less padding on smaller screens */
    }

    .form-row {
        flex-direction: column; /* Stack vertically on small screens */
    }

    .form-group {
        margin-right: 0; /* Remove right margin on small screens */
        margin-bottom: 15px; /* Spacing between stacked elements */
    }

    h2 {
        font-size: 24px; /* Smaller font size for headings */
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="tel"],

    select {
        padding: 12px; /* Less padding on smaller screens */
    }

    button {
        font-size: 15px; /* Smaller font size for buttons */
    }
}


    </style>
    <div class="container">
        <h2>User Registration</h2>
        <form action="register.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="for">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <div class="for">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>