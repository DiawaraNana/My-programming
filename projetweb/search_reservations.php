
<?php
session_start();
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui") {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
include_once('db.php');

// Initialisation des réservations
$reservations = [];

// Traitement de la recherche
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['room_number'])) {
    $room_number = htmlspecialchars($_POST['room_number']);

    try {
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE room_number = :room_number");
        $stmt->bindParam(':room_number', $room_number);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la recherche : " . $e->getMessage());
    }
} else {
    // Récupérer toutes les réservations si aucune recherche n'est effectuée
    try {
        $reservations = $conn->query("SELECT * FROM reservations")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des réservations : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les Réservations</title>
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
            padding: 20px;
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 200px;
            height: auto;
        }

        .container {
            margin-top: 100px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: darkgreen;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background: yellowgreen;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button i {
            margin-right: 5px;
        }

        button:hover {
            background: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: yellowgreen;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: yellowgreen;
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
    <h1>Liste des Réservations</h1>

    <form method="POST" action="">
        <input type="text" name="room_number" placeholder="Rechercher par numéro de chambre">
        <button type="submit"><i class="fas fa-search"></i> </button>
    </form>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom du Client</th>
            <th>Numéro de Chambre</th>
            <th>Date d'Arrivée</th>
            <th>Date de Départ</th>
            <th>Statut</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($reservations)) : ?>
            <?php foreach ($reservations as $reservation) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['check_in_date']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['check_out_date']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Aucune réservation trouvée.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
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
