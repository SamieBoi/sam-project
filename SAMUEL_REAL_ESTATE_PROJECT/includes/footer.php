<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
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

    </style>
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