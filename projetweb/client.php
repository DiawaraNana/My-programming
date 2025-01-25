<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une chambre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("images.jpeg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            height: 100vh;
            display: flex; /* Utiliser Flexbox */
            justify-content: center; /* Centrer horizontalement */
            align-items: center; /* Centrer verticalement */
        }

        .container {
            width: 40%; /* Réduire la largeur à 40% de la largeur de la fenêtre */
            max-width: 500px; /* Réduire la largeur maximale à 500px */
            background-color: white;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Empêcher les débordements */
        }

        .image-container {
            width: 100%;
        }

        .image-container img {
            width: 100%; /* Ajuste l'image à la largeur de la div */
            height: auto; /* Préserve les proportions */
        }

        .form-container {
            padding: 15px; /* Réduire le padding */
        }

        h2 {
            font-size: 22px; /* Réduire la taille de la police */
            font-family: "Times New Roman";
            color: darkgreen;
            text-align: center;
            margin-bottom: 15px; /* Réduire la marge inférieure */
        }

        .form-group {
            margin-bottom: 15px; /* Réduire la marge entre les groupes de formulaire */
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px; /* Réduire le padding */
            margin: 4px 0; /* Réduire la marge */
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px; /* Réduire la taille de la police */
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px; /* Réduire le padding */
            background-color: #1b5e20;
            color: white;
            font-size: 16px; /* Réduire la taille de la police */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #689f38;
            color: black;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .message {
            font-size: 16px; /* Réduire la taille de la police */
            margin-bottom: 15px; /* Réduire la marge inférieure */
            text-align: center;
        }

        .message.error {
            color: red;
        }

        .message.success {
            color: green;
        }
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 200px;
            height: auto;
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
        <li><a href="client.php">faire Reservation</a></li>
        <li><a href="view_reservation.php">Voir Réservations</a></li>
        <li><a href="hotel.php">Déconnexion</a></li>
    </ul>
</div>
<div class="container">
    <!-- Div contenant l'image -->
    <div class="image-container">
        <img src="hotel.png" alt="Image Hôtel">
    </div>

    <!-- Div contenant le formulaire -->
    <div class="form-container">
        <h2>Réserver une chambre</h2>

        <?php
        // Connexion à la base de données
        include_once('db.php');

        // Récupération des chambres disponibles
        $available_rooms = [];
        try {
            $stmt_rooms = $conn->prepare("SELECT room_number FROM rooms WHERE availability_date <= CURDATE()");
            $stmt_rooms->execute();
            $available_rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p class='message error'>Erreur lors de la récupération des chambres : " . $e->getMessage() . "</p>";
        }

        // Traitement du formulaire
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $client_name = htmlspecialchars($_POST['client_name']);
            $room_number = htmlspecialchars($_POST['room_number']);
            $check_in_date = htmlspecialchars($_POST['check_in_date']);
            $check_out_date = htmlspecialchars($_POST['check_out_date']);

            try {
                // Vérification des doublons
                $stmt_check = $conn->prepare("SELECT * FROM reservations WHERE room_number = :room_number AND ((check_in_date <= :check_out_date AND check_out_date >= :check_in_date))");
                $stmt_check->bindParam(':room_number', $room_number);
                $stmt_check->bindParam(':check_in_date', $check_in_date);
                $stmt_check->bindParam(':check_out_date', $check_out_date);
                $stmt_check->execute();

                if ($stmt_check->rowCount() > 0) {
                    echo "<p class='message error'>La chambre est déjà réservée pour ces dates.</p>";
                } else {
                    // Insertion de la réservation
                    $stmt = $conn->prepare("INSERT INTO reservations (client_name, room_number, check_in_date, check_out_date) VALUES (:client_name, :room_number, :check_in_date, :check_out_date)");
                    $stmt->bindParam(':client_name', $client_name);
                    $stmt->bindParam(':room_number', $room_number);
                    $stmt->bindParam(':check_in_date', $check_in_date);
                    $stmt->bindParam(':check_out_date', $check_out_date);

                    if ($stmt->execute()) {
                        echo "<p class='message success'>Réservation effectuée avec succès !</p>";
                    } else {
                        echo "<p class='message error'>Erreur lors de la réservation.</p>";
                    }
                }
            } catch (PDOException $e) {
                echo "<p class='message error'>Erreur lors du traitement : " . $e->getMessage() . "</p>";
            }
        }
        ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="client_name" placeholder="Nom du client" required>
            </div>

            <div class="form-group">
                <select name="room_number" required>
                    <option value="">Sélectionnez une chambre</option>
                    <?php foreach ($available_rooms as $room): ?>
                        <option value="<?= $room['room_number']; ?>">Chambre <?= $room['room_number']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <input type="date" name="check_in_date" required>
            </div>

            <div class="form-group">
                <input type="date" name="check_out_date" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Réserver">
            </div>
        </form>
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