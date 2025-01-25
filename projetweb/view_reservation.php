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

// Rechercher toutes les réservations existantes pour le client
$query = "SELECT * FROM reservations WHERE client_name = :client_name AND status = 'Active'";
$stmt = $conn->prepare($query);
$stmt->bindParam(':client_name', $clientName);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher Réservations</title>
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
        h2 {
            text-align: center;
            color: darkgreen;
            margin-top: 20px;
        }
        table {
            width: 70%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: yellowgreen;
            color: white;
        }
        td {
            font-size: 16px;
            color: #333;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .icon {
            cursor: pointer;
            font-size: 20px;
            text-decoration: none;
            color: yellowgreen;
            transition: color 0.3s;
        }
        .icon:hover {
            color: #45a049;
        }
        .no-reservations {
            text-align: center;
            font-size: 18px;
            color: #ff6347;
            margin-top: 20px;
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

<h2>Mes Réservations</h2>

<?php if (count($reservations) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>Numéro de chambre</th>
            <th>Date d'arrivée</th>
            <th>Date de départ</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= htmlspecialchars($reservation['room_number']); ?></td>
                <td><?= htmlspecialchars($reservation['check_in_date']); ?></td>
                <td><?= htmlspecialchars($reservation['check_out_date']); ?></td>
                <td>
                    <a href="modifier.php?id_reservation=<?= $reservation['id']; ?>" class="icon">
                        &#x270E;
                    </a>
                </td>
                <td>
                    <a href="supprimer.php?id_reservation=<?= $reservation['id']; ?>" class="icon">
                        &#x1F5D1;
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-reservations">Aucune réservation trouvée pour vous.</p>
<?php endif; ?>
<script>
    // Fonction pour afficher/masquer le menu
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
</script>

</body>
</html>
