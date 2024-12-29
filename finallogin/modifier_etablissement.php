<?php
include('db_connect.php');

// Vérifier si l'ID de l'école est passé en paramètre GET
if (isset($_GET['id_ecole'])) {
    $id_etablissement = $_GET['id_ecole'];

    // Requête pour récupérer les données de l'établissement
    $query = "SELECT * FROM etablissement WHERE id_ecole = :id_ecole";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_ecole', $id_etablissement);
    $stmt->execute();

    $etablissement = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement du formulaire de modification
        if (isset($_POST['id_ecole'])) {
            // Récupérer les nouvelles valeurs du formulaire
            $id_ecole = $_POST['id_ecole'];
            $nom_u = $_POST['nom_u'];
            $email_u = $_POST['email_u'];

            // Requête pour mettre à jour l'établissement dans la base de données
            $update_query = "UPDATE etablissement SET nom_u = :nom_u, email_u = :email_u WHERE id_ecole = :id_ecole";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bindParam(':nom_u', $nom_u);
            $update_stmt->bindParam(':email_u', $email_u);
            $update_stmt->bindParam(':id_ecole', $id_ecole);

            if ($update_stmt->execute()) {
                // Message de succès après mise à jour
                echo "<p class='message' style='color: green; text-align: center;'>École mise à jour avec succès !</p>";
                // Redirection après modification
                header('Location: table_ecole.php');
                exit();
            } else {
                echo "<p class='message' style='color: red; text-align: center;'>Une erreur s'est produite lors de la mise à jour de l'école.</p>";
            }
        }
    }
} else {
    echo "<p class='message' style='color: red; text-align: center;'>École non trouvée.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier École</title>
    <style>
        /* Styles pour l'image en haut de la page */
        .header-image {
            width: 70%;
            display: block;
            margin: 0 auto;
            margin-bottom: 30px;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(100deg, #FFFFFF, #154360 ,#0e6251);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }


        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width:900px;
            height:400px;
            margin-top: 50px;
        }


        .container:hover {
            transform: translateY(-10px);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #154360 ;
            font-family: "Times New Roman";
            font-size: 40px;
        }

        .form-group {
            margin-bottom: 50px;
            background-color: #003e4d;
            color: #FFFFFF;
            font-size: 18px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid darkblue;
            font-size: 18px;
        }

        .form-group input:focus {
            border-color: #0056B3;
            color:#154360 ;
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
            outline: none;
        }

        .form-group input[type="submit"] {
            background-color: #0b5345;
            color: white;
            cursor: pointer;
            border: none;
            font-size: 22px;
            font-family: "Times New Roman", serif;
        }

        .form-group input[type="submit"]:hover {
            background-color: #003f73;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Modifier École</h2>

    <?php if ($etablissement): ?>
        <form method="POST" action="">
            <input type="hidden" name="id_ecole" value="<?php echo htmlspecialchars($etablissement['id_ecole']); ?>" />
            <div class="form-group">
                <input type="text" name="nom_u" value="<?php echo htmlspecialchars($etablissement['nom_u']); ?>" required />
            </div>

            <div class="form-group">
                <input type="email" name="email_u" value="<?php echo htmlspecialchars($etablissement['email_u']); ?>" required />
            </div>

            <div class="form-group">
                <input type="submit" value="Modifier" />
            </div>
        </form>
    <?php else: ?>
        <p>École non trouvée.</p>
    <?php endif; ?>
</div>
</body>
</html>
