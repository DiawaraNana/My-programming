<?php
// Inclure le fichier de connexion à la base de données
include_once('db_connect.php');

// Initialisation des messages d'erreur et de succès
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données sont envoyées et existent dans $_POST
    if (isset($_POST['nom_u']) && isset($_POST['email_u'])) {
        // Récupérer les données du formulaire
        $nom_u = $_POST['nom_u'];
        $email_u = $_POST['email_u'];

        // Vérification des doublons : vérifier si le nom ou l'email existe déjà
        $stmt_check = $conn->prepare("SELECT * FROM etablissement WHERE nom_u = :nom_u OR email_u = :email_u");
        $stmt_check->bindParam(':nom_u', $nom_u);
        $stmt_check->bindParam(':email_u', $email_u);
        $stmt_check->execute();

        // Si un établissement avec ce nom ou email existe déjà
        if ($stmt_check->rowCount() > 0) {
            $error_message = "Le nom ou l'email de l'établissement existe déjà. Veuillez choisir un autre.";
        } else {
            // Si le nom et l'email sont uniques, procéder à l'insertion
            // Préparer l'insertion dans la base de données
            $stmt = $conn->prepare("INSERT INTO etablissement (nom_u, email_u) VALUES (:nom_u, :email_u)");
            $stmt->bindParam(':nom_u', $nom_u);
            $stmt->bindParam(':email_u', $email_u);

            // Exécuter l'insertion
            if ($stmt->execute()) {
                $success_message = "L'établissement a été ajouté avec succès!";
            } else {
                $error_message = "Erreur lors de l'ajout de l'établissement, veuillez réessayer.";
            }
        }
    } else {
        // Si les clés 'nom_u' ou 'email_u' ne sont pas définies
        $error_message = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    /* Styles pour l'image en haut de la page */
    .header-image {
        width: 60%; /* L'image occupe 70% de la largeur de la page */
        display: block;
        margin: 0 auto; /* Centrer l'image */
        margin-bottom: 40px; /* Ajoute un petit espace entre l'image et le formulaire */
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
    .container {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 750px;
        height: 700px;
        margin-top: 50px;
    }
.container:focus {
    border-color: #0056B3;
    box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);

}
.container:hover{
        transform: translateY(-10px);
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #0056B3;
        font-family: "Times New Roman";
        font-size: 40px;
    }

    .form-group {
        margin-bottom: 50px;

        color: #FFFFFF;
        font-size: 18px;
    }


    .form-group input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 18px;
    }

    .form-group input:focus {
        border-color: #0056B3;
        color: #333 ;
        outline: none;
    }

    .form-group input[type="submit"] {
        background-color: #0b5345;
        color: white;
        cursor: pointer;
        border: none;
        font-size: 18px;
        font-family: "Times New Roman", serif;
    }

    .form-group input[type="submit"]:hover {
        background-color: #003f73;
    }

    .message {
        text-align: center;
        font-weight: bold;
    }

    .error {
        color: red;
    }

    .success {
        color: green;
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


<div class="container">
    <img src="UEMF_etudiantma.png" alt="Image d'établissement" class="header-image">
    <h2>Ajouter un établissement</h2>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php
    if (!empty($error_message)) {
        echo "<p class='message error'>$error_message</p>";
    }
    if (!empty($success_message)) {
        echo "<p class='message success'>$success_message</p>";
    }
    ?>

    <form method="POST" action="">
        <div class="form-group">

            <input type="text" name="nom_u" id="nom_u" placeholder="Nom de l'établissement" required>
        </div>

        <div class="form-group">

            <input type="email" name="email_u" id="email_u" placeholder="Email de l'établissement" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Ajouter établissement">
        </div>
    </form>
</div>


</body>
</html>
