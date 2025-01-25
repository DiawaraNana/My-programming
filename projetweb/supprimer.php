<?php
session_start();
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] != "oui") {
    header("Location: loginhotel.php");
    exit();
}

include_once('db.php');

// Récupérer l'ID de la réservation
$reservation_id = $_GET['id_reservation'] ?? null;
$error_message = '';
$success_message = '';

if ($reservation_id) {
    // Récupérer les détails de la réservation
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = :id_reservation AND client_name = :client_name");
    $stmt->bindParam(':id_reservation', $reservation_id);
    $stmt->bindParam(':client_name', $_SESSION['client_name']);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        $error_message = "Réservation introuvable ou vous n'avez pas les droits pour l'annuler.";
    }

    // Si l'utilisateur confirme l'annulation
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        $stmt_delete = $conn->prepare("DELETE FROM reservations WHERE id = :id_reservation AND client_name = :client_name");
        $stmt_delete->bindParam(':id_reservation', $reservation_id);
        $stmt_delete->bindParam(':client_name', $_SESSION['client_name']);

        if ($stmt_delete->execute()) {
            $success_message = "La réservation a été annulée avec succès.";
        } else {
            $error_message = "Une erreur est survenue lors de l'annulation.";
        }
    }
} else {
    header("Location: client.php"); // Redirection si l'ID de réservation est manquant ou invalide
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuler la réservation</title>
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
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }



        .container {
            width: 40%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: darkgreen;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group a {
            text-decoration: none;
        }

        .form-group input[type="button"] {
            background-color: darkgreen;
            color: white;
            border-radius: 15px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .form-group input[type="button"]:hover {
            background-color: yellowgreen;
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
    <h2>Annuler votre réservation</h2>

    <!-- Affichage des messages -->
    <?php if (!empty($success_message)): ?>
        <p class="message success"><?= htmlspecialchars($success_message); ?></p>
    <?php elseif (!empty($error_message)): ?>
        <p class="message error"><?= htmlspecialchars($error_message); ?></p>
    <?php elseif ($reservation): ?>
        <!-- Demande de confirmation -->
        <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
        <p><strong>-Numéro de chambre :</strong> <?= htmlspecialchars($reservation['room_number']); ?></p>
        <p><strong>-Date d'arrivée :</strong> <?= htmlspecialchars($reservation['check_in_date']); ?></p>
        <p><strong>-Date de départ :</strong> <?= htmlspecialchars($reservation['check_out_date']); ?></p>

        <div class="form-group">
            <a href="supprimer.php?id_reservation=<?= $reservation_id; ?>&confirm=true">
                <input type="button" value="Confirmer l'annulation">
            </a>
            <a href="view_reservation.php">
                <input type="button" value="Retour">
            </a>
        </div>
    <?php endif; ?>
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
