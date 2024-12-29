<?php
include('db_connect.php');

// Vérifier si l'ID de l'étudiant est passé en paramètre GET
if (isset($_GET['id_etudiant'])) {
    // Récupérer l'ID de l'étudiant via GET
    $id_etudiant = $_GET['id_etudiant'];

    // Requête pour récupérer les données de l'étudiant
    $query = "SELECT * FROM etudiant_in_u WHERE id_etudiant = :id_etudiant";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_etudiant', $id_etudiant);
    $stmt->execute();

    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement du formulaire de modification
        if (isset($_POST['id_etudiant'])) {
            // Récupérer les nouvelles valeurs du formulaire
            $id_e = $_POST['id_etudiant'];
            $nom_e = $_POST['nom_e'];
            $email_e = $_POST['email_e'];

            // Requête pour mettre à jour l'étudiant dans la base de données
            $update_query = "UPDATE etudiant_in_u SET nom_e = :nom_e, email_e = :email_e WHERE id_etudiant = :id_etudiant";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bindParam(':nom_e', $nom_e);
            $update_stmt->bindParam(':email_e', $email_e);
            $update_stmt->bindParam(':id_etudiant', $id_etudiant);

            if ($update_stmt->execute()) {
                echo "<p>Étudiant mis à jour avec succès.</p>";
                // Rediriger après modification (facultatif)
                header('Location: table_etudiants.php');
                exit();
            } else {
                echo "<p>Une erreur s'est produite lors de la mise à jour de l'étudiant.</p>";
            }
        }
    }
} else {
    echo "<p>Étudiant non trouvé.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier étudiant</title>
    <style>
        /* Styles CSS comme dans votre exemple précédent */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #0e6251, #d7bde2, #3498db);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(85deg, #0b5345 , #3498db);
            z-index: -1;
        }

        .division {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border-radius: 15px;
            padding: 30px 40px;
            width: 100%;
            max-width: 60%;
            height: 400px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .division:hover {
            transform: translateY(-10px);
        }

        .login-box {
            text-align: center;
            width: 100%;
        }


        .action-links a {
            text-decoration: none;
            color: #3498db;
            margin: 0 10px;
            font-weight: bold;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        h2 {
            margin-bottom: 30px;
            color: #0b5345;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        input {
            border-radius: 10px;
            height: 40px;
            width: 100%;
            margin-top: 15px;
            padding: 0 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #0056B3;
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #0056B3;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background: #0b5345;
        }

        .login-img {
            width: 250px;
            height: auto;
            margin-right: 40px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>


<div class="division">
    <img src="im1.png" alt="image" class="login-img">

    <div class="login-box">
        <h2>Modifier Étudiant</h2>

        <?php if ($etudiant): ?>
            <form method="POST" action="">
                <input type="hidden" name="id_etudiant" value="<?php echo $etudiant['id_etudiant']; ?>" />
                <label for="nom_e">Nom:</label>
                <input type="text" name="nom_e" value="<?php echo htmlspecialchars($etudiant['nom_e']); ?>" required /><br />

                <label for="email_e">Email:</label>
                <input type="email" name="email_e" value="<?php echo htmlspecialchars($etudiant['email_e']); ?>" required /><br />

                <input type="submit" value="Modifier" class="login-btn" />
            </form>
        <?php else: ?>
            <p>Étudiant non trouvé.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
