<?php
// Inclure le fichier de connexion à la base de données
include_once('db_connect.php');

// Initialisation des messages d'erreur et de succès
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données sont envoyées et existent dans $_POST
    if (isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['etablissement'])) {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $etablissement_id = $_POST['etablissement'];  // ID de l'établissement

        // Vérification des doublons : vérifier si le nom ou l'email existe déjà
        $stmt_check = $conn->prepare("SELECT * FROM etudiant_in_u WHERE nom_e = :nom OR email_e = :email");
        $stmt_check->bindParam(':nom', $nom);
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();

        // Si un étudiant avec ce nom ou email existe déjà
        if ($stmt_check->rowCount() > 0) {
            $error_message = "Le nom ou l'email existe déjà. Veuillez choisir un autre.";
        } else {
            // Si le nom et l'email sont uniques, procéder à l'insertion
            // Aucune gestion de mot de passe ici, donc on omet le hashage de mot de passe

            // Préparer l'insertion dans la base de données
            $stmt = $conn->prepare("INSERT INTO etudiant_in_u (nom_e, email_e, id_etablissement) VALUES (:nom, :email, :etablissement_id)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':etablissement_id', $etablissement_id);  // L'ID de l'établissement

            // Exécuter l'insertion
            if ($stmt->execute()) {
                $success_message = "L'étudiant a été ajouté avec succès!";
            } else {
                $error_message = "Erreur lors de l'ajout de l'étudiant, veuillez réessayer.";
            }
        }
    } else {
        // Si les clés 'nom', 'email' ou 'etablissement' ne sont pas définies
        $error_message = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout étudiant</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #0e6251, #d7bde2, #3498db);
            height: 100vh;  /* Ajuster la hauteur pour ne pas dépasser la hauteur de l'écran */
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
            background: linear-gradient(85deg, #0b5345 , #3498db,#f5eef8);  /* Réutiliser le même dégradé dans ::before */
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
        header{
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
            color:#0b5345;
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
        select {
            border-radius: 10px;
            height: 40px;
            width: 100%;
            margin-top: 10px;
        }

        input:focus {
            border-color: #0056B3;
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
        } input:hover {
            background-color:#0b5345;
            color: #FFFFFF;

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
            background: #003f73;
        }

        .login-img {
            width: 250px;
            height: auto;
            margin-right: 40px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        }


        select:focus {
            border-color: #0056B3;
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
            background-color: #0b5345;
            color: #FFFFFF;
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

<div class="division">
    <img src="login_img02.png" alt="log" class="login-img">

    <div class="login-box">
        <h2>Inscription Étudiant</h2>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php
        if (!empty($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        if (!empty($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        }
        ?>

        <form method="post" action="">
            <div class="h2"><b>Nom</b></div>
            <input type="text" name="nom" placeholder="Nom étudiant" required/>

            <div class="h2"><b>Email</b></div>
            <input type="email" name="email" placeholder="email" required/><br/><br/><br/>

            <label for="etablissement">Choisir l'établissement :</label>
            <select name="etablissement" required>
                <!-- Liste déroulante des établissements générée dynamiquement -->
                <?php
                // Se connecter à la base de données pour obtenir les établissements
                $stmt = $conn->prepare("SELECT id_ecole, nom_u FROM etablissement");
                $stmt->execute();
                $etablissements = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Remplir la liste déroulante avec les établissements
                foreach ($etablissements as $etablissement) {
                    echo "<option value='" . $etablissement['id_ecole'] . "'>" . $etablissement['nom_u'] . "</option>";
                }
                ?>
            </select><br>

            <input type="submit" name="valider" value="Envoyer"/><br/>
        </form>


    </div>
</div>

</body>
</html>
