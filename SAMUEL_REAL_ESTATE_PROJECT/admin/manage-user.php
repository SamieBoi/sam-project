<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $user_id = $_POST['user_id'];
        $delete_query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update_role'])) {
        $user_id = $_POST['user_id'];
        $new_role = $_POST['role'];
        $update_query = "UPDATE users SET role = ? WHERE user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $new_role, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage-users.php</title>
    <link rel="stylesheet" href="./manage-user.css">
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td>
                            <form action="manage-users.php" method="POST" class="update-role-form">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="role" onchange="this.form.submit()">
                                    <option value="admin" <?php if ($row['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                                    <option value="agent" <?php if ($row['role'] === 'agent') echo 'selected'; ?>>Agent</option>
                                </select>
                                <input type="hidden" name="update_role" value="1">
                            </form>
                        </td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <form action="manage-users.php" method="POST" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>