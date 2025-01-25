<?php
session_start();
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-image: url("nana.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .division {
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.2); /* Fond noir semi-transparent */
            border-radius: 15px;
            padding: 30px 40px;
            width: 40%;
            height: auto;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            backdrop-filter: blur(10px); /* Ajout d'un flou pour un effet plus esthétique */
            border: 1px solid rgba(255, 255, 255, 0.3); /* Bordure subtile */
            color: white; /* Texte en blanc pour une bonne lisibilité */
        }

        h2 {
            margin-bottom: 30px;
            color: yellowgreen;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            font-family: Comic Sans MS, Comic Sans, cursive;
            letter-spacing: 2px;
            padding: 5px;
            border-radius: 10px;
        }

        .division:hover {
            transform: translateY(-10px);
        }

        input {
            border-radius: 10px;
            height: 50px;
            width: 100%;
            margin-top: 15px;
            padding: 0 15px;
            font-size: 18px;
            border: 1px solid #ddd;
            font-family: "Times New Roman";
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
        }

        .login-box {
            text-align: center;
            width: 100%;
        }

        input[type="submit"], input[type="button"] {
            background-color: rgba(154, 205, 50, 0.9); /* Vert clair semi-transparent */
            color: white;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            border: none;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: rgba(124, 252, 0, 0.9); /* Couleur verte plus vive */
        }

        input:hover {
            color: green;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
<img src="zest-removebg-preview.png" alt="Logo" class="logo">

<div class="division">
    <div class="login-box">
        <h2>Menu Principal</h2>
        <form method="POST" action="">
            <div>
                <a href="add_rooms.php"><input type="button" value="Ajouter les chambres disponibles"></a>
            </div>
            <div>
                <a href="search_reservations.php"><input type="button" value="Rechercher des réservations"></a>
            </div>
            <div>
                <a href="reservations_graph.php"><input type="button" value="Graphe des réservations"></a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
