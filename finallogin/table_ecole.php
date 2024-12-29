<?php
// Inclure la connexion à la base de données
include('db_connect.php');

// Requête pour récupérer les établissements
$query = "SELECT * FROM etablissement";
$stmt = $conn->prepare($query);
$stmt->execute();

// Récupérer tous les résultats
$etablissements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les établissements</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(100deg, #2980b9 ,#b3b6b7 );
            color: #fff;
        }

        header {
            background-color: #154360;
            padding: 15px 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            margin: 0 20px;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #f4d03f;
        }

        .content {
            margin-top: 100px; /* Pour laisser de l'espace sous le menu fixe */
            text-align: center;
            padding: 20px;
        }

        h2 {
            font-size: 28px;
            color:  #0b5345;
            margin-bottom: 20px;
            font-family: "Times New Roman";
            text-decoration: underline;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 70px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
         .image-top{
             position: absolute; /* Permet de positionner l'image par rapport à son parent (ici le body) */
        top: 50px; /* Distance du haut de la fenêtre */
        width: 200px; /* Largeur de l'image */
        height: 150px;  /* Hauteur de l'image */
        border-radius: 5px; /* Coins arrondis */
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2); /* Ombre élégante */
        z-index: 2; /* Assure que l'image est au-dessus du background */
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-family: "Times New Roman";
            font-size: 22px;
        }

        th {
            background-color: #154360;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #154360;
        }

        tr:hover {
            background-color: #fdfefe;
            color: black;
        }

        .action-links a {
            text-decoration: none;
            color: #154360;
            margin: 0 10px;
            font-weight: bold;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="table_etudiants.php">Afficher étudiants</a>
        <a href="ajout_etudiant.php">Ajouter étudiant</a>
        <a href="table_ecole.php">Afficher écoles</a>
        <a href="ajout_ecole.php">Ajouter école</a>
    </nav>
</header>
<img src="euromed.jpg" alt="log" class="image-top">
<div class="content">
    <h2>Liste des établissements</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Afficher les établissements dans un tableau
        foreach ($etablissements as $etablissement) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($etablissement['id_ecole']) . "</td>";
            echo "<td>" . htmlspecialchars($etablissement['nom_u']) . "</td>";
            echo "<td>" . htmlspecialchars($etablissement['email_u']) . "</td>";
            echo "<td class='action-links'>
                <a href='modifier_etablissement.php?id_ecole=" . $etablissement['id_ecole'] . "'>
                    <i class='fas fa-edit'></i> Modifier
                </a> | 
                <a href='supprimer_etablissement.php?id_ecole=" . $etablissement['id_ecole'] . "'>
                    <i class='fas fa-trash-alt'></i> Supprimer
                </a>
              </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
