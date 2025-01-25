<?php
session_start();
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui") {
    header("Location: login.php");
    exit();
}

include_once('db.php');

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_number = htmlspecialchars($_POST['room_number']);
    $availability_date = htmlspecialchars($_POST['availability_date']);

    if (!empty($room_number) && !empty($availability_date)) {
        try {
            // Vérifier si la chambre existe déjà
            $checkQuery = "SELECT * FROM rooms WHERE room_number = :room_number";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bindParam(':room_number', $room_number);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error_message = "La chambre existe déjà.";
            } else {
                // Insérer la chambre dans la base de données
                $sql = "INSERT INTO rooms (room_number, availability_date) VALUES (:room_number, :availability_date)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':room_number', $room_number);
                $stmt->bindParam(':availability_date', $availability_date);
                $stmt->execute();

                $success_message = "Chambre ajoutée avec succès.";
            }
        } catch (PDOException $e) {
            $error_message = "Erreur lors de l'ajout de la chambre : " . $e->getMessage();
        }
    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des chambres</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

        }

        .logo {
            position: absolute;
            top: 20px;
            left: 3px;
            width: 200px;
            height: auto;
        }

        .container {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 800px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-container {
            flex: 1;
            margin-right: 20px;
        }

        .image-container {
            flex: 1;
        }

        .image-container img {
            width: 100%;
            border-radius: 10px;
        }

        .room-icon {
            display: block;
            margin: 0 auto 20px;
            font-size: 50px;
            color: yellowgreen;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #555;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 90%;
        }

        button {
            padding: 10px;
            font-size: 16px;
            color: black;
            background: yellowgreen;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: greenyellow;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .success {
            background: yellowgreen;
            color: black;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }
        /* Bouton de menu */
        .menu-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: yellowgreen;
            color: black;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .menu-button:hover {
            background-color: darkgreen;
        }

        /* Menu */
        .menu {
            position: fixed;
            top: 60px;
            right: 20px;
            background-color: yellowgreen;
            border: 1px solid #ddd;
            border-radius: 5px;

            display: none; /* Masqué par défaut */
            z-index: 1000;
        }

        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .menu ul li a {
            text-decoration: none;
            color: black;
            display: block;
            width: 100%;
            height: 100%;
        }
        .menu ul li {

            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            color: black;
        }

        .menu ul li:hover {
            background-color: darkgreen;
        }

        .menu ul li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
<img src="zest-removebg-preview.png" alt="Logo" class="logo">
<!-- Bouton de menu -->
<button class="menu-button" onclick="toggleMenu()">☰ Menu</button>

<!-- Menu déroulant -->
<div class="menu" id="menu">
    <ul>
        <li><a href="add_rooms.php">Ajouter des chambres</a></li>
        <li><a href="search_reservations.php">Recherche des Reservations</a></li>
        <li><a href="reservations_graph.php">Graphe Réservation</a></li>
        <li><a href="hotel.php">Déconnexion</a></li>
    </ul>
</div>
<div class="container">
    <div class="form-container">
        <i class="fas fa-bed room-icon"></i>
        <h1>Ajouter une chambre</h1>
        <?php if (!empty($success_message)) : ?>
            <div class="message success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)) : ?>
            <div class="message error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="room_number">Numéro de chambre :</label>
            <input type="text" id="room_number" name="room_number" required>

            <label for="availability_date">Date de disponibilité :</label>
            <input type="date" id="availability_date" name="availability_date" required>

            <button type="submit">Ajouter</button>
        </form>
    </div>
    <div class="image-container">
        <img src="chambre.jpg" alt="Image Chambre">
    </div>
</div>
<script>
    // Fonction pour afficher/masquer le menu
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
</script>
</body>
</html>
