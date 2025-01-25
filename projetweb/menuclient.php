<?php
session_start();
include('db.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] != "oui") {
    header("Location: loginhotel.php");
    exit();
}

// Assurez-vous que le nom du client est défini, sinon affichez un message par défaut.
$clientName = isset($_SESSION["client_name"]) ? $_SESSION["client_name"] : "Invité";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Client - Zest Hotel</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("images.jpeg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;


            position: relative;
        }

        /* Logo en haut à gauche */
        .logo {
            position: absolute;
            top: 10px;
            left: 2px;
            width: 200px;
            height: 100px;
        }
        .container {
            display: flex;
            max-width: 1000px;
            width: 70%;
            background-color: white;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .left-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .left-section h2 {
            font-size: 32px;
            margin: 0;
            color: #004d40;
        }
        /* Style du logo */
        img.img_zest {
            width: 200px; /* Largeur ajustée du logo */
            height: 150px;
        }
        .h{
            font-family: "Times New Roman";
            font-size: 17px;
            color: #004d40;
            text-align: center;
        }
        .left-section p {
            margin-top: 10px;
            font-size: 18px;
            color: #555;
        }

        .button {
            display: block;
            text-align: center;
            padding: 15px 20px;
            margin: 20px 0;
            font-size: 16px;
            font-family: Arial, serif;
            color: white;
            background-color: #689f38 ;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .button:hover {
            background-color: darkgreen;
            transform: scale(1.03);
        }

        .logout {
            margin-top: 20px;
            color: #1b5e20 ;
            display: block;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            padding: 15px 20px;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .logout:hover {
            background-color: darkgreen;
            color: white;

        }

        .right-section {
            flex: 1;
            background: url('imagezest2.jpg') no-repeat center center / cover;
        }
    </style>
</head>
<body>
<div class="logo">
    <img src="zest-removebg-preview.png" alt="Logo" class="logo">
</div>
<div class="container">
    <!-- Section gauche (texte et boutons) -->
    <div class="left-section">
        <h2 class="h">Bienvenue à Zest Hotel <strong><?= htmlspecialchars($clientName); ?></strong> !</h2>
        <h3 class="h">  Profitez de votre séjour avec nos meilleurs services. </h3>

        <a href="client.php" class="button">Get a room!</a>
        <a href="view_reservation.php" class="button">Afficher mes réservations</a>
        <a href="hotel.php" class="logout">Se déconnecter</a>
    </div>

    <!-- Section droite (image) -->
    <div class="right-section"></div>
</div>
</body>
</html>

