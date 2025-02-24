<?php
include './includes/db_connect.php';

// Handle login check
$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : ''; // Fetch username if logged in
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;// Fetch email if logged in
$phone = $isLoggedIn ? $_SESSION['phone'] : null;

// Handle search functionality
$search = '';
$type = '';
$status = '';
$city = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'] ?? '';
    $type = $_POST['property_type'] ?? '';
    $status = $_POST['status'] ?? '';
    $city = $_POST['city'] ?? '';
}

$sql = "SELECT * FROM properties WHERE title LIKE ?";

if (!empty($type)) {
    $sql .= " AND property_type = ?";
}
if (!empty($status)) {
    $sql .= " AND status = ?";
}
if (!empty($city)) {
    $sql .= " AND location LIKE ?";
}

// Prepare statement
$stmt = $conn->prepare($sql);
$params = ["%$search%"];
if (!empty($type)) $params[] = $type;
if (!empty($status)) $params[] = $status;
if (!empty($city)) $params[] = "%$city%";

$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Query to get recent properties (limit to 6)
$recent_sql = "SELECT property_id, title, description, price, location, image, square_footage, bedrooms, bathrooms, year_built, status, added_at FROM properties ORDER BY added_at DESC LIMIT 3";
$recent_result = $conn->query($recent_sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navbar.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <style>

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        /* background-color: #f4f4f4; */
    }
    .header {
    padding: 2rem 9%;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    /* border:2px solid red; */

    background: #ffffff;
}
.line img{
    width: 1.0rem;
    header:1.0rem;
}
.line {
    display: flex;
    align-items: center;
    gap:0.1rem;
}
.login{
    display: flex;
    align-items: center;
    gap:0.5rem;

}
.login img{
    width: 1.0rem;
    header:1.0rem;
}
.login img{
    width: 1.0rem;
    header:1.0rem;
}
.navbar{
    display:flex;
    gap:2rem;
}
.navbar a{
    text-decoration:none;
    color:gray;
    font:900;
}
.login span a{
    text-decoration:none;
    color:white;

}
.login span{
    font-size:0.5rem;

}
.line span{
    font-size:0.5rem;
    color:white;
}
.twothing{
    display:flex;
    align-items:center;
    gap:1rem;
}
.wholeinside{
    /* border:2px solid red; */
    background-color: orange;
    padding:0.5rem;
    display:flex;
    align-items:center;

    justify-content:space-between;

}
#menu-btn {
    margin-right:3rem;
    cursor:pointer;
    /* background-color: orange; */
}
#menu-btn a{
    text-decoration:none;
    background-color: orange;
    border: 2px solid orange;
    padding:1rem;
    border-radius:15rem;
    color:white;

}
#menu-btn a:hover{
    background-color: rgb(136, 105, 49);
}
    section {
    /* padding: 2rem; */
    /* border:2px solid red; */
}
.sectiontwo{
    /* position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000; */
    box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
}

 .sectiontwo img{
    width: 5rem;
    height:5rem;
    /* border:green 2px solid; */
 }
 .wholethings{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-left:4rem;
 }
 .othertwo{
    display:flex;
    align-items:center;
    gap:3rem;
 }
 .sectionthree{
    /* border:red solid 2px; */
    background-image:url("./img/eye.jpg");
    background-size: cover;
  background-repeat: no-repeat;
 }
 .insidediv{
    /* border:green solid 2px; */
    padding:5rem 9%;
 }
 .insidediv h1{
    font-size:2rem;
    color:orange;
    font:900;

 }
 .insidediv span{
    color:white;
 }
 .sectionfour{
    background: #eeeeee;

    /* border:2px solid green; */
 }
 .lineone{
    width: 200px;
    border-color:orange;
 }
 .linetwo{
    width: 400px;
    border-color:orange;


 }
 .insidedivfour{
    padding:2rem ;
 }
 .insidedivfour h3{
    text-align:center;
    font-size:2rem;
    color:orange;

}
    </style>
<header  id="sectionone">
    <nav class="navbarone">
        <div class="wholeinside">
            <div class="twothing">
                <div class="line">
                    <img src="./img/whatsapp.png" alt="">
                    <?php if ($phone): ?>
                        <span><?php echo htmlspecialchars($phone); ?> <!-- Display phone number --></span>
                    <?php endif; ?>
                </div>

                <div class="line">
                    <img src="./img/email.png" alt="">
                    <!-- Only display email if it exists -->
                    <?php if ($email): ?>
                        <span><?php echo htmlspecialchars($email); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="login">
                <img src="./img/user.png" alt="">

                <span>hi</span>
                <span>

                    <?php if ($isLoggedIn): ?>
                        <?php echo htmlspecialchars($username); ?>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
</header>
<!-- ends -->
<section class="sectiontwo">
    <div class="wholethings">
    <div class="othertwo">

<a href="" class="logo"><img src="./img/WhatsApp Image 2024-11-02 at 03.45.03_2e30bccb.jpg" alt=""></a>

<nav class="navbar">
    <a href="./home.php">Home</a>
    <a href="./about.php">About</a>
    <a href="./Properties.php">Properties</a>
    <a href="./agent/agent-login.php">Agent</a>
    <a href="./account.php"> My Account</a>

    <?php if ($email): ?>
            <!-- Display the user's email and hide login/register links -->
            <!-- <p>Welcome, <?php echo htmlspecialchars($email); ?>!</p> -->
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <!-- Display login/register links if the user is not logged in -->
            <a href="login.php">Login/Register</a>

        <?php endif; ?>

</nav>
</div>
<div id="menu-btn" >
    <a href="submit-property.php">Submit Property</a>
    </div>
</div>
</section>
<!-- end -->
        </body>
        </html>