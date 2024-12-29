<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Affichage des utilisateurs</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #154360 , #d0d3d4 , #3498db  );
            height: 100vh; /* S'assure que la page couvre toute la hauteur de la fenêtre */
            position: relative;
            justify-content: center;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Superposition d'un filtre semi-transparent sur le fond */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);  /* Filtre sombre */
            z-index: -1;
        }


        h2 {
            font-family: "Times New Roman", serif;
            margin-top: 30px;
            color: #333;
            font-size: 30px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            border-radius: 10px;
        }
        h2:hover{
            background-color: #2874a6;
            color: #dee1ff;
        }

        table {
            width: 80%;
            max-width: 1200px;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Pour arrondir les coins */
        }

        thead, th {
            height: 50px;
            background-color: #1b4f72;
            color: #fff;
            font-size: 20px;
            font-family: "Times New Roman", serif;
            text-align: center;
        }

        tr {
            background-color: #d6dbdf;
            transition: background-color 0.3s ease;
        }

        tr:hover {
            background-color: #2874a6; /* Couleur de fond lors du survol */
            cursor: pointer;
        }

        td {
            font-size: 18px;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            color: #333;
            font-family: "Times New Roman", serif;
        }

        td:first-child {
            font-weight: bold;
        }

        /* Style du lien "Retour au formulaire" */
        a {
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #2471a3 ;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #003f73;
        }

        /* Styles pour mobile */
        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }

            table {
                width: 95%;
            }

            td, th {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<h2>Affichage du tableau des étudiants</h2>

<?php
// Paramètres de connexion à la base de données
// Inclure la connexion à la base de données
include('connect.php');  // Inclure le fichier de connexion

// Récupérer les données des utilisateurs
$result = $conn->query("SELECT login, email FROM users");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead><th>Login</th><th>Email</th></thead>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['login'] . "</td><td>" . $row['email'] . "</td></tr>";
    }

    echo "</table><br>";
} else {
    echo "<p>Aucune donnée à afficher.</p>";
}

// Fermer la connexion
$conn->close();
?>

<a href="projet1.php">Retour au formulaire</a>

</body>
</html>
