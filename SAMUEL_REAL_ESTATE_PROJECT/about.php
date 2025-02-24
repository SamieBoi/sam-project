<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>about.php</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        .about-section {
    padding: 40px;
    background-color: #f4f4f4;
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
}

.about-container h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 36px;
    color: #333;
}

.about-container p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.about-container h2 {
    margin-top: 30px;
    font-size: 28px;
    color: #444;
}

.about-container ul {
    list-style-type: none;
    padding: 0;
}

.about-container ul li {
    background: #e8e8e8;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
}

.team-members {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin: 20px 0;
}

.team-member {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin: 15px;
    padding: 15px;
    width: calc(30% - 30px);
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.team-member img {
    max-width: 100%;
    height: auto;
    border-radius: 50%;
    margin-bottom: 10px;
}

.team-member h3 {
    font-size: 20px;
    margin: 10px 0;
}

.team-member p {
    font-size: 14px;
    margin: 5px 0;
}

@media (max-width: 768px) {
    .team-member {
        width: calc(45% - 30px);
    }
}

@media (max-width: 480px) {
    .team-member {
        width: 100%;
    }
}

    </style>

<?php
session_start();
include './includes/navbar.php';
 ?>

<section class="about-section">
    <div class="about-container">
        <h1>About Us</h1>
        <p>
            Welcome to [Your Company Name], where we connect people with their dream properties. Our mission is to provide our clients with unparalleled service and expert advice in the real estate market.
        </p>

        <h2>Our Mission</h2>
        <p>
            At [Your Company Name], we believe in putting our clients first. We strive to create a seamless and enjoyable real estate experience for buyers, sellers, and renters alike. Our mission is to guide you through every step of the real estate process with transparency and professionalism.
        </p>

        <h2>Our Values</h2>
        <ul>
            <li><strong>Integrity:</strong> We uphold the highest standards of honesty and ethics.</li>
            <li><strong>Customer Focus:</strong> Our clients are our priority. We listen to your needs and work diligently to meet them.</li>
            <li><strong>Excellence:</strong> We are committed to delivering quality service in every transaction.</li>
            <li><strong>Innovation:</strong> We embrace new technologies to enhance the real estate experience.</li>
        </ul>

        <h2>Meet Our Team</h2>
        <div class="team-members">
            <div class="team-member">
                <img src="./images/team1.jpg" alt="Team Member Name">
                <h3>John Doe</h3>
                <p>Founder & CEO</p>
                <p>With over 15 years of experience in the real estate industry, John is passionate about helping clients find their perfect homes.</p>
            </div>
            <div class="team-member">
                <img src="./images/team2.jpg" alt="Team Member Name">
                <h3>Jane Smith</h3>
                <p>Sales Manager</p>
                <p>Jane leads our sales team with expertise and dedication, ensuring a smooth transaction for every client.</p>
            </div>
            <div class="team-member">
                <img src="./images/team3.jpg" alt="Team Member Name">
                <h3>Michael Johnson</h3>
                <p>Property Consultant</p>
                <p>Michael specializes in residential properties and is committed to helping clients navigate the market.</p>
            </div>
        </div>

        <h2>Our Services</h2>
        <p>
            We offer a wide range of real estate services, including:
        </p>
        <ul>
            <li>Residential Sales</li>
            <li>Commercial Real Estate</li>
            <li>Property Management</li>
            <li>Investment Consulting</li>
            <li>Market Analysis</li>
        </ul>
    </div>
</section>

<?php include './includes/footer.php'; // Include your footer file ?>

</body>
</html>