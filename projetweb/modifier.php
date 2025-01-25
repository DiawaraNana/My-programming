<?php
session_start();
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] != "oui") {
    header("Location: loginhotel.php");
    exit();
}

include_once('db.php');

// Récupérer l'ID de la réservation à modifier
$reservation_id = $_GET['id_reservation'] ?? null;
$reservation = null;
$error_message = "";
$success_message = "";

// Récupérer les informations de la réservation
if ($reservation_id) {
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = :id_reservation");
    $stmt->bindParam(':id_reservation', $reservation_id);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $room_number = $_POST['room_number'];
        $check_in_date = $_POST['check_in_date'];
        $check_out_date = $_POST['check_out_date'];

        // Vérifier la disponibilité de la chambre
        $stmt_check = $conn->prepare("SELECT * FROM reservations WHERE room_number = :room_number AND id != :id_reservation AND ((check_in_date <= :check_out_date AND check_out_date >= :check_in_date))");
        $stmt_check->bindParam(':room_number', $room_number);
        $stmt_check->bindParam(':check_in_date', $check_in_date);
        $stmt_check->bindParam(':check_out_date', $check_out_date);
        $stmt_check->bindParam(':id_reservation', $reservation_id);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            $error_message = "La chambre est déjà réservée pour ces dates.";
        } else {
            // Mettre à jour la réservation
            $stmt_update = $conn->prepare("UPDATE reservations SET room_number = :room_number, check_in_date = :check_in_date, check_out_date = :check_out_date WHERE id = :id_reservation");
            $stmt_update->bindParam(':room_number', $room_number);
            $stmt_update->bindParam(':check_in_date', $check_in_date);
            $stmt_update->bindParam(':check_out_date', $check_out_date);
            $stmt_update->bindParam(':id_reservation', $reservation_id);

            if ($stmt_update->execute()) {
                $success_message = "La réservation a été modifiée avec succès.";
            } else {
                $error_message = "Erreur lors de la modification de la réservation.";
            }
        }
    }
} else {
    header("Location: client.php");
    exit();
}

// Récupérer les chambres disponibles
$available_rooms = [];
$stmt_rooms = $conn->prepare("SELECT room_number FROM rooms WHERE room_number NOT IN (
    SELECT room_number FROM reservations WHERE (:check_in_date < check_out_date AND :check_out_date > check_in_date)
)");
$stmt_rooms->bindParam(':check_in_date', $reservation['check_in_date']);
$stmt_rooms->bindParam(':check_out_date', $reservation['check_out_date']);
$stmt_rooms->execute();
$available_rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la réservation</title>
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
            overflow: hidden
        }

        .container {
            width: 55%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
        }

        h2 {
            text-align: center;
            color: green;
        }

        .flex-container {
            display: flex;
            gap: 20px;
        }

        .form-container {
            flex: 1;
        }

        .image-container {
            flex: 1;
        }

        .image-container img {
            width: 400px;
            height: 350px;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 16px;
            color: #333;
        }

        .form-group select, .form-group input {
            width: 90%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
            font-size: 16px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
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
    <!-- Messages d'erreur ou de succès -->
    <?php if (!empty($error_message)) echo "<p class='message error'>$error_message</p>"; ?>
    <?php if (!empty($success_message)) echo "<p class='message success'>$success_message</p>"; ?>

    <div class="flex-container">
        <!-- Formulaire de modification -->
        <div class="form-container">
            <h2>Modifier votre réservation</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="room_number">Numéro de la chambre :</label>
                    <select name="room_number" id="room_number" required>
                        <?php
                        foreach ($available_rooms as $room) {
                            $selected = $room['room_number'] == $reservation['room_number'] ? "selected" : "";
                            echo "<option value='{$room['room_number']}' $selected>Chambre {$room['room_number']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="check_in_date">Date d'arrivée :</label>
                    <input type="date" name="check_in_date" id="check_in_date" value="<?= htmlspecialchars($reservation['check_in_date']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="check_out_date">Date de départ :</label>
                    <input type="date" name="check_out_date" id="check_out_date" value="<?= htmlspecialchars($reservation['check_out_date']); ?>" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Modifier la réservation">
                </div>
            </form>
        </div>

        <!-- Image de la chambre -->
        <div class="image-container">
            <img src="hotelzest.jpg" alt="Image Chambre">
        </div>
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
