<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Hotel Room Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #cddc39, #155724);
            color: #fff;
            text-align: center;
        }

        /* Barre d'entête */
        .top-bar {
            background-color: #155724;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
        }

        .top-bar .section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar i {
            font-size: 18px;
            color: #d4e157; /* Couleur des icônes */
        }

        .top-bar a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .top-bar a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 20px;
        }

        header h1 {
            font-size: 70px;
            margin: 10px 0;
        }

        header p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .images {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .images img {
            width: 350px;
            height: 350px;
            object-fit: cover;
            border-radius: 10px;
        }

        .why-us {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .why-us h2 {
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .why-us ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        .why-us li {
            margin: 0;
            font-size: 1.1em;
            font-weight: bold;
            gap: 15px;
        }

        footer {
            margin-top: 20px;
        }

        footer .info {
            margin-bottom: 10px;
        }

        footer .cta button {
            background-color: greenyellow;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
        }

        footer .cta button:hover {
            background-color: #d4e157;
        }
        .logo {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 270px;
            height: auto;
        }
    </style>
</head>
<body>
<img src="zest-corporate.png" alt="Logo" class="logo">
<!-- Barre d'entête -->
<div class="top-bar">
    <div class="section">
        <span>LANGUAGE</span>
        <i class="fas fa-flag-usa"></i>
        <i class="fas fa-flag"></i>
    </div>
    <div class="section">
        <i class="fas fa-search"></i>
        <a href="#">Find a Hotel</a>
    </div>
    <div class="section">
        <i class="fas fa-check-circle"></i>
        <a href="#">Best Rate Guarantee</a>
    </div>
    <div class="section">
        <i class="fas fa-wifi"></i>
        <a href="#">Free Wifi Access</a>
    </div>
    <div class="section">
        <i class="fas fa-phone-alt"></i>
        <span>Reservations: 0800 1 6767 88</span>
    </div>
</div>

<div class="container">
    <header>
        <h1>Luxury <br> Hotel Room Bookings</h1>
        <p>Our collection includes the latest trends and timeless classics. Shop the trends and stay ahead of the curve!</p>
    </header>
    <section class="images">
        <img src="imagehotel.jpg" alt="Hotel 1">
        <img src="imagezest2.jpg" alt="Hotel 2">
        <img src="imagehotel2.jpg" alt="Hotel 3">
    </section><br><br>
    <h2>Why Stay With Us?</h2>
    <section class="why-us">
        <ul>
            <li>Central Location</li>
            <li>Modern Amenities</li>
            <li>Exceptional Service</li>
        </ul>
    </section>
    <footer>
        <div class="info">
            <p>Visit Us At:</p>
            <p> Anywhere St, Any City in Indonesia</p>
        </div>
        <div class="cta">
            <button onclick="goToLogin()">Réservez maintenant!</button>
        </div>
    </footer>
</div>
<script>
    function goToLogin() {
        window.location.href = "projetpage1.php";
    }
</script>
</body>
</html>
