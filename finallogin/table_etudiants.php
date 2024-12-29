<?php
// Inclure la connexion à la base de données
include('db_connect.php'); // Assurez-vous que 'db_connect.php' contient la logique correcte de connexion

// Requête pour récupérer les étudiants et leur établissement
$query =  "
SELECT 
    etudiant_in_u.id_etudiant, 
    etudiant_in_u.nom_e AS nom_etudiant, 
    etudiant_in_u.email_e, 
    etablissement.nom_u
FROM 
    etudiant_in_u 
JOIN 
    etablissement 
ON 
    etudiant_in_u.id_etablissement = etablissement.id_ecole
";

// Préparer et exécuter la requête
$stmt = $conn->prepare($query);
$stmt->execute();

// Récupérer tous les résultats
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les établissements</title>
    <style>
        body {
            margin: 0;
            padding: 0;

            font-family: 'Arial', sans-serif;
            background: linear-gradient(100deg, #2980b9 ,#b3b6b7 );
            height: 100vh;
            color: #fff;
            position: relative;
            overflow: hidden;
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
            color: #0b5345;
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
            height: 100px;
        }


        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-family: "Times New Roman";
            font-size: 22px;
        }

        th {
            background-color: #154360 ;
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
            color: black;
            margin: 0 10px;
            font-weight: bold;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
        .asup {
            color: #154360;
            /* Couleur rouge foncé pour le lien de suppression */
            font-weight: bold;  /* Met en gras le texte */
            text-decoration: none;  /* Enlève le soulignement */
            transition: color 0.3s ease;
        }

        .asup:hover {
            /* Couleur rouge clair au survol */
            text-decoration: underline;  /* Sous-ligne le texte au survol */
        }

        .amod {
             color: #154360;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .amod:hover {
           /* Couleur dorée claire au survol */
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

<div class="content">
<h2 style="text-align:center;">Liste des étudiants</h2>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Etablissement</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Afficher les étudiants dans un tableau
    foreach ($etudiants as $etudiant) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($etudiant['id_etudiant']) . "</td>";
        echo "<td>" . htmlspecialchars($etudiant['nom_etudiant']) . "</td>";
        echo "<td>" . htmlspecialchars($etudiant['email_e']) . "</td>";
        echo "<td>" . htmlspecialchars($etudiant['nom_u']) . "</td>";
        echo "<td><a href='modifier_etudiant.php?id_etudiant=" . $etudiant['id_etudiant'] . "' class='amod'>
                        <i class='fas fa-edit'></i> Modifier
                      </a> | 
                      <a href='supprimer_etudiant.php?id_etudiant=" . $etudiant['id_etudiant'] . "' class='asup'>
                        <i class='fas fa-trash-alt'></i> Supprimer
                      </a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</div>
</body>
</html>

