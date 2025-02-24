<?php
session_start();
include './includes/db_connect.php';


// Start session for login tracking


// Handle login check
$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
$username = $isLoggedIn ? $_SESSION['username'] : ''; // Fetch username if logged in
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;// Fetch email if logged in
$phone = $isLoggedIn ? $_SESSION['phone'] : null;


// Rest of the search functionality code...
$totalProperties = $conn->query("SELECT COUNT(*) as count FROM properties")->fetch_assoc()['count'];
$saleProperties = $conn->query("SELECT COUNT(*) as count FROM properties WHERE status = 'For Sale'")->fetch_assoc()['count'];
$rentProperties = $conn->query("SELECT COUNT(*) as count FROM properties WHERE status = 'For Rent'")->fetch_assoc()['count'];
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM user")->fetch_assoc()['count'];



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
    <title>homepage.php</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
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
    <a href="#home">Home</a>
    <a href="about.php">About</a>
    <a href="properties.php">Properties</a>
    <a href="./agent/agent-login.php">Agent</a>
    <a href="account.php"> My Account</a>

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
 <section class="sectionthree">
    <div class="insidediv">
        <h1>LET US <br> <span>GUIDE YOUR HOME</span></h1>
        <div>
        <form action="view-properties.php" method="POST" class="search-form">
            <input type="text" name="search" placeholder="Search by title" value="<?php echo htmlspecialchars($search); ?>">
            <input type="text" name="city" placeholder="Enter city" value="<?php echo htmlspecialchars($city); ?>">
            <select name="property_type">
                <option value="">All Types</option>
                <option value="Apartment" <?php if ($type == 'Apartment') echo 'selected'; ?>>Apartment</option>
                <option value="House" <?php if ($type == 'House') echo 'selected'; ?>>House</option>
                <option value="Office" <?php if ($type == 'Office') echo 'selected'; ?>>Office</option>
                <option value="Land" <?php if ($type == 'Land') echo 'selected'; ?>>Land</option>
            </select>
            <select name="status">
                <option value="">All Status</option>
                <option value="For Sale" <?php if ($status == 'For Sale') echo 'selected'; ?>>For Sale</option>
                <option value="For Rent" <?php if ($status == 'For Rent') echo 'selected'; ?>>For Rent</option>
            </select>
            <button type="submit">Search Properties</button>
        </form>

        </div>

 </section>
 <!-- end -->
  <section class=sectionfour>
    <div class=insidedivfour>
        <h3>WHAT DO WE DO <span>?</span></h3>
        <hr class="lineone">
        <hr class="linetwo">

    </div>
    <div class="allfour">
        <div class="subfour">
            <img src="./img/WhatsApp Image 2024-11-02 at 03.53.23_f022de98.jpg" alt="">
            <h3>Selling Service</h3>
            <p>We sell any property of your choice at affordable price from your comfort zone.  </p>
        </div>

        <div class="subfour">
            <img src="./img/WhatsApp Image 2024-11-02 at 03.53.36_100e08f7.jpg" alt="">
            <h3>Buying Service</h3>
            <p> Property Max buys different property like Houses, Cars, Land,etc.  </p>
        </div>

        <div class="subfour">
            <img src="./img/WhatsApp Image 2024-11-02 at 03.53.33_0bbc3fe5.jpg" alt="">
            <h3>Renting Service</h3>
            <p>Property Max rent property suitable for the family, personal or business purpose.  </p>
        </div>

        <div class="subfour">
            <img src="./images/5ede15e3cce1396f1cdd7f8b09f1e590.jpg" alt="">
            <h3>Development Service</h3>
            <p>Property max is expertised in the development of properties to the taste of customers.  </p>
        </div>
    </div>
  </section>

  <!-- END -->
  <section class="sectionfive">
   <div class="insidedivfour">
        <h3>AVAILABLE PROPERTIES</h3>
        <hr class="lineone">
        <hr class="linetwo">
    </div>

   <div class="otherinsiderd">
   <?php while ($property = $result->fetch_assoc()) : ?>
    <div class="insidefive">
        <div class="row1">
            <img src="./images/<?php echo $property['image']; ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
        </div>
        <div class="row2">
            <h3><?php echo htmlspecialchars($property['title']); ?></h3>
            <div class="price">
                <div class="locationpin">
                    <img src="./img/WhatsApp Image 2024-11-02 at 03.53.33_a6c84b3c.jpg" alt="">
                    <p><?php echo htmlspecialchars($property['location']); ?></p>
                </div>
                <div class="locationpin">

                    <img src="./img/WhatsApp Image 2024-11-02 at 03.53.33_0bbc3fe5.jpg" alt="">
                    <p>$<?php echo htmlspecialchars($property['price']); ?></p>
                </div>
            </div>
        </div>
        <div class="insiderow">
            <div class="row3">
                <p><?php echo htmlspecialchars($property['square_footage']); ?> <br>Sqt</p>
                <p><?php echo htmlspecialchars($property['bedrooms']); ?> <br> Beds</p>
                <p><?php echo htmlspecialchars($property['bathrooms']); ?> <br> Baths</p>
                <p><?php echo htmlspecialchars($property['year_built']); ?><br>Year Built</p>
            </div>
        </div>
        <div class="rows4">
            <p>Status: <?php echo htmlspecialchars($property['status']); ?></p>
            <p><?php echo htmlspecialchars($property['added_at']); ?></p>
        </div>
        <a href="property-detail.php?id=<?php echo $property['property_id']; ?>" class="view-details-btn">View Details</a>
    </div>
    <?php endwhile; ?>
    </div>
</section>



    <section class="sectionfive">
   <div class=insidedivfour>
        <h3>RECENT PROPERTY</h3>
        <hr class="lineone">
        <hr class="linetwo">

    </div>

   <div class="otherinsiderd">
   <?php while ($recent_property = $recent_result->fetch_assoc()) : ?>
    <div class="insidefive">

        <div class="row1"> <img src="./images/<?php echo $recent_property['image']; ?>" alt="<?php echo htmlspecialchars($recent_property['title']); ?>"></div>


        <div class="row2">
        <h3><?php echo htmlspecialchars($recent_property['title']); ?></h3>
            <div class="price">
                <div class="locationpin">
                <img src="./img/WhatsApp Image 2024-11-02 at 03.53.33_a6c84b3c.jpg" alt="">
                <p><?php echo htmlspecialchars($recent_property['location']); ?></p>
   </div>
   <div class="locationpin">
   <img src="./img/WhatsApp Image 2024-11-02 at 03.53.33_0bbc3fe5.jpg" alt="">
 
                <p>$<?php echo htmlspecialchars($recent_property['price']); ?></p>

   </div>

        </div>


        </div>

<div class="insiderow">
            <div class="row3">
            <p><?php echo htmlspecialchars($recent_property['square_footage']); ?> <br>Sqt</p>
            <p><?php echo htmlspecialchars($recent_property['bedrooms']); ?> <br> Beds</p>
            <p><?php echo htmlspecialchars($recent_property['bathrooms']); ?> <br> Baths</p>
            <p><?php echo htmlspecialchars($recent_property['year_built']); ?><br>Year Built</p>
            </div>
</div>

        <div class="rows4">
            <p>Status: <?php echo htmlspecialchars($recent_property['status']); ?></p>
            <p><?php echo htmlspecialchars($recent_property['added_at']); ?></p>
        </div>
        <a href="property-detail.php?id=<?php echo $recent_property['property_id']; ?>" class="view-details-btn">View Details</a>
    </div>
    <?php endwhile; ?>
    </div>
   </section>

   <!-- ends -->

<section class="sectionsix">

    <div class="insidesix">
    <h3>Why Choose Us</h3>
     <div class="money_bag">
        <img src="./img/love.jpg" alt="">
        <div class="rated">
            <h4>Top Rated</h4>
        <p>This is a dimmy text for filling out spaces .This is just a dimmy space for filling out blank space</p>
       </div>

    </div>

    <div  class="money_bag">
        <img src="./img/love.jpg" alt="">
        <div class="rated">
            <h4>Most trusted</h4>
        <p>This is a dimmy text for filling out spaces .This is just a dimmy space for filling out blank space</p>
       </div>

    </div>

    <div  class="money_bag">
        <img src="./img/love.jpg" alt="">
        <div class="rated">
            <h4>Affordable Price</h4>
        <p>This is a dimmy text for filling out spaces .This is just a dimmy space for filling out blank space</p>
       </div>

    </div>
   </div>
   </section>
      <!-- ends -->

      <section class="how-it-works">
      <div class=insidedivfour>
        <h3>HOW IT WORKS</h3>
        <hr class="lineone">
        <hr class="linetwo">

    </div>
    <div class="steps-container">
        <div class="step">
            <div class="step-icon"><sup>1</sup><img src="./img/WhatsApp Image 2024-11-02 at 03.53.35_ccad3871.jpg" alt=""></div>
            <hr>
            <div class="step-content">
                <h4>Step 1</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-icon"><sup>2</sup><img src="./img/WhatsApp Image 2024-11-02 at 03.53.35_ccad3871.jpg" alt=""></div>
            <hr>
            <div class="step-content">
                <h4>Step 2</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-icon"><sup>3</sup><img src="./img/WhatsApp Image 2024-11-02 at 03.53.35_ccad3871.jpg" alt=""></div>
            <hr>
            <div class="step-content">
                <h4>Step 3</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>
        </div>
    </div>
</section>

<!-- ends -->

<section class="property-stats-section">
    <!-- <h3>Our Stats</h3> -->
    <div class="stats-container">
        <div class="stat-card">
            <h4>Available Properties</h4>
            <p><?php echo $totalProperties; ?></p>
        </div>
        <div class="stat-card">
            <h4>Properties for Sale</h4>
            <p><?php echo $saleProperties; ?></p>
        </div>
        <div class="stat-card">
            <h4>Properties for Rent</h4>
            <p><?php echo $rentProperties; ?></p>
        </div>
        <div class="stat-card">
            <h4>Registered Users</h4>
            <p><?php echo $totalUsers; ?></p>
        </div>
    </div>
</section>
<!-- ends -->
<section class="popular-places">
    <div class=insidedivfour>
        <h3>POPULAR PLACES</h3>
        <hr class="lineone">
        <hr class="linetwo">

    </div>
    <div class="places-container">
        <?php
        // Sample data for demonstration; replace with your database query if needed
        $popular_places = [
            ["img" => "london.jpg", "location" => "New York City"],
            ["img" => "paris.jpg", "location" => "Paris"],
            ["img" => "china.jpg", "location" => "Tokyo"],
            ["img" => "beach.jpg", "location" => "Dubai"],

        ];

        foreach ($popular_places as $place) : ?>
            <div class="place-card">
                <img src="./img/<?php echo $place['img']; ?>" alt="<?php echo htmlspecialchars($place['location']); ?>">
                <div class="place-name"><?php echo htmlspecialchars($place['location']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<!-- ends -->

<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h4>Contact Us</h4>
            <p>Real Estate Company</p>
            <p>Email: info@realestatecompany.com</p>
            <p>Phone: +1 (123) 456-7890</p>
            <p>Address: 123 Main St, City, Country</p>
        </div>
        <div class="footer-section">
            <h4>Useful Links</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Properties for Sale</a></li>
                <li><a href="#">Properties for Rent</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-media">
                <a href="#"><img src="./images/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="./images/image.png" alt="Twitter"></a>
                <a href="#"><img src="./images/instagram.png" alt="Instagram"></a>
                <a href="#"><img src="./images/message.png" alt="LinkedIn"></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Real Estate Company. All rights reserved.</p>
    </div>
</footer>





</body>
</html>



<style>
    /* Add this CSS to your style.css file */

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
    background-image:url("./img/orange.jpg");
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
 .insidedivfour span{
    font-size:4rem;
    color:black;
    font:bolder;
 }
 .allfour{
    display:flex;
    align-items:center;
    padding: 2rem 9%;
    gap:2rem;
 }
 .subfour{
    /* border:2px solid black; */
    box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);

    display:flex;
    flex-direction:column;
    /* padding:1% ; */
    /* flex-wrap:wrap; */
    align-items:center;

    /* background: #eeeeee; */
    border-radius: .5rem;
    box-shadow: var(--box-shadow);
    /* border: var(--border); */
    /* padding: 2.5rem; */

 }
 .subfour p{
text-align:center;
color:#777;
    line-height: 2;


 }
 .insidesix{
    /* border:2px solid red; */

    padding:2rem;
    background-color: rgb(90, 90, 107);

    /* position: absolute; */
    opacity: 0.9;


    width:50%;
 }
 .insidesix h3{
    font-size:24px;
    color:orange;
    /* text-shadow:6px 6px 6px  gray; */
    font-weight:900;
 }
 .rated h4{
    font-size:20px;
    color:orange;
 }
 .rated p{
    font-size:18px;
    color:white;
  font-family: 'Times New Roman', Times, serif;


 }
.money_bag{
    /* border:2px solid blue; */
    display:flex;
    /* width:50%; */
    align-items:start;
    gap:1rem;
}
.money_bag p{
    line-height:1.5;
}
.money_bag img{
    width:50px;
    height:50px;
}
 .subfour img{
    width:100px;
    height:100px;
 }
 /* end */
 .sectionfive{
    /* border:2px solid red; */
    /* display:flex; */
    padding:1rem 2%;

 }
 .otherinsiderd{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:1rem;

 }
 .insidefive{
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin: 15px;
    padding: 15px;
    width: calc(30% - 50px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
 }
 .row1 img{
    width: 100%;

 }
 .row2 h3{
    font-size:18px;
    color:orange;
 }
 .locationpin{
    display:flex;
    align-items:center;
 }
 .locationpin img{
    width:20px;
    height:20px;
 }
 .locationpin p{
    font-size:15px;
    color:gray;
 }
 .insidefive a{
    text-decoration:none;
    color:white;
    /* border:1px solid #333; */
    border-radius:1rem;
    padding:5px;
    background-color:orange;
 }
 .insidefive a:hover{
    transition: ease-out 0.9s;
    /* transform: translateY(5px); */
background-color: #333;

 }

 .price{
    display:flex;
    justify-content:space-between;
    margin-top:2rem;
 }
 .row3{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0%;
 }
 .insiderow{
    background-color:#eeee;
    padding:0;
 }
 .row3 p{
    text-align:center;
    color:gray;
    font-size:12px;
 }

 .rows4{
    display:flex;
    justify-content:space-between;


 }
 .rows4 p{
    font-size:10px;
    color:gray;
 }
 .sectionsix{
    /* border:2px solid green; */

    background-image:url("./img/bolb.jpg");
  /* height: 90vh; */
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  background-color: rgb(224, 214, 197);
  justify-content: center;
  width: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  /* padding: 0 80px; */
  background-position: top 28% right 0;
 }

 .how-it-works {
    text-align: center;
    padding: 20px;
    background-color: #f9f9f9;
}

.how-it-works h3 {
    font-size: 2em;
    margin-bottom: 20px;
    color: #333;
}

.steps-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.step {
    display: flex;
    flex-direction: row;
    align-items: center;
    /* width: 100%; */
    min-width: 200px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.step-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
    width: 60px;
    height: 60px;
    margin-right: 20px;
}

.step-icon img {
    width: 100px;
    height: 100px;
}
.step-icon sup{
    border:1px solid orange;
    border-radius:10rem;
    padding:5px;
    background-color: orange;
    color:white;
}

.step hr {
    flex: 1;
    border: none;
    height: 1px;
    background: #ddd;
    margin: 0 20px;
}

.step-content h4 {
    font-size: 1.3em;
    margin: 0 0 5px 0;
    color: #333;
}

.step-content p {
    margin: 0;
    font-size: 0.9em;
    color: #666;
}
.property-stats-section {
    padding: 20px;
    text-align: center;
    background-color: #f8f9fa;
}

.stats-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.stat-card {
    flex: 1 1 200px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: scale(1.05);
}

.stat-card h4 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: orange;
    font-weight:900;
}

.stat-card p {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
}
.popular-places {
    text-align: center;
    padding: 2em;
}

.places-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1em;
}

.place-card {
    position: relative;
    width: 250px;
    height: 500px;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.place-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.place-name {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 1em;
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    font-size: 1.2em;
    text-align: center;
    font-weight: bold;
}



/* Responsive Adjustments */
@media (max-width: 768px) {
    .steps-container {
        flex-direction: column;
    }

    .step {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .step hr {
        display: none;
    }

    .step-content p {
        padding: 10px 0;
    }
}

    .container {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
        margin-top: 30px;
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-form input,
    .search-form select,
    .search-form button {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .search-form button {
        background-color: orange;
        color: white;
        border: none;
        cursor: pointer;
    }

    .search-form button:hover {
        background-color: #218838;
    }

    .property-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.property-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 10px;
    padding: 20px;
    flex: 1 1 calc(33.333% - 20px); /* 3 cards per row with margin */
    box-sizing: border-box;
    transition: transform 0.2s;
}

.property-card:hover {
    transform: scale(1.02);
}

.property-card img {
    width: 100%;
    height: auto;
    border-radius: 8px 8px 0 0;
}

.property-card h3 {
    font-size: 1.5em;
    margin: 10px 0;
}

.property-card p {
    margin: 5px 0;
}

.property-card a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background: #007BFF;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s;
}

.property-card a:hover {
    background: #0056b3;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .property-card {
        flex: 1 1 calc(50% - 20px); /* 2 cards per row on smaller screens */
    }
}
.footer {
    background-color: orange;
    color: #fff;
    padding: 2em 0;
    font-size: 0.9em;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2em;
}

.footer-section {
    flex: 1;
    min-width: 200px;
    margin: 1em;
}

.footer-section h4 {
    margin-bottom: 1em;
    font-size: 1.2em;
    border-bottom: 2px solid #fff;
    padding-bottom: 0.5em;
}

.footer-section p, .footer-section ul {
    margin: 0.5em 0;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li a {
    color: #fff;
    text-decoration: none;
}

.footer-section ul li a:hover {
    text-decoration: underline;
}

.social-media {
    display: flex;
    gap: 1em;
}

.social-media img {
    width: 30px;
    height: 30px;
}

.footer-bottom {
    text-align: center;
    margin-top: 2em;
    padding-top: 1em;
    border-top: 1px solid #555;
}


    @media (max-width: 600px) {
        .search-form {
            flex-direction: column;
        }

        .search-form input,
        .search-form select,
        .search-form button {
            width: 100%;
        }
    }
</style>