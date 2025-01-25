<?php
session_start();
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui") {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
include_once('db.php');

// Récupération des données pour le graphique
try {
    $query = "SELECT MONTH(check_in_date) AS month, COUNT(*) AS total FROM reservations GROUP BY MONTH(check_in_date) ORDER BY month";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $months = [];
    $reservations = [];

    foreach ($data as $row) {
        $months[] = $row['month'];
        $reservations[] = $row['total'];
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphique des Réservations</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            flex-direction: column;
            align-items: center;
            justify-content: center;

        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 200px;
            height: auto;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 800px;
        }

        h1 {
            text-align: center;
            color: yellowgreen;
            margin-bottom: 20px;
        }

        canvas {
            max-width: 100%;
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
    <h1>Graphique des Réservations par Mois</h1>
    <canvas id="reservationsChart"></canvas>
</div>

<script>
    const ctx = document.getElementById('reservationsChart').getContext('2d');
    const reservationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>, // Mois
            datasets: [{
                label: 'Nombre de Réservations',
                data: <?php echo json_encode($reservations); ?>, // Totaux
                backgroundColor: 'rgba(212, 240, 200, 1)',
                borderColor: 'rgba(240, 248, 231, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre de Réservations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            }
        }
    });
</script>
<script>
    // Fonction pour afficher/masquer le menu
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
</script>
</body>
</html>

