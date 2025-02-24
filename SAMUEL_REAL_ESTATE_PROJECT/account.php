<?php
session_start();
include './includes/db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id = '$user_id'";
$user_result = $conn->query($sql);
$user = $user_result->fetch_assoc();

// Update user information
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_info'])) {
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];

    // Update user information in the database
    $update_sql = "UPDATE user SET email = '$new_email', phone = '$new_phone' WHERE id = '$user_id'";
    $conn->query($update_sql);

    // Refresh user information
    $user_result = $conn->query($sql);
    $user = $user_result->fetch_assoc();
}

// Change password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the current password matches
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $change_password_sql = "UPDATE user SET password = '$hashed_password' WHERE id = '$user_id'";
            $conn->query($change_password_sql);
            $success_message = "Password changed successfully!";
        } else {
            $error_message = "New passwords do not match.";
        }
    } else {
        $error_message = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>account.php</title>
    <link rel="stylesheet" href="styles/account.css"> <!-- Link to your CSS file -->
</head>
<body>
    <style>

main {
    padding: 20px;
}

.user-info, .change-password {
    background: #ffffff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin: 10px 0 5px;
}

input {
    padding: 10px;
    margin-bottom: 10px;
}

button {
    padding: 10px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

.error {
    color: red;
}

.success {
    color: green;
}


    </style>
    <?php
include './includes/navbar.php';
?>

    <main>
        <section class="user-info">
            <h2>Your Information</h2>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

                <button type="submit" name="update_info">Update Information</button>
            </form>
        </section>

        <section class="change-password">
            <h2>Change Password</h2>
            <?php if (isset($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <p class="success"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit" name="change_password">Change Password</button>
            </form>
        </section>
    </main>

    <?php
include './includes/footer.php';
?>
</body>
</html>