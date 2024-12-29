<?php
// Inclure la connexion à la base de données
include('connect.php');  // Inclure le fichier de connexion

// Vérifier si le formulaire a été soumis
$error_message = "";  // Initialisation d'une variable pour les erreurs
$success_message = ""; // Initialisation d'une variable pour le succès

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['log'];
    $email = $_POST['email'];
    $pass_word = $_POST['pass'];

    // Vérification des doublons : vérifier si l'email ou le login existe déjà
    $stmt_check = $conn->prepare("SELECT * FROM users WHERE login = ? OR email = ?");
    $stmt_check->bind_param("ss", $login, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    // Si un utilisateur avec ce login ou email existe déjà
    if ($result_check->num_rows > 0) {
        $error_message = "L'email ou le login existe déjà. Veuillez choisir un autre.";
    } else {
        // Si l'email et le login sont uniques, procéder à l'inscription
        $hashed_password = password_hash($pass_word, PASSWORD_DEFAULT);  // Sécuriser le mot de passe

        // Préparer l'insertion dans la base de données
        $stmt = $conn->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $login, $email, $hashed_password);

        // Exécuter l'insertion
        if ($stmt->execute()) {
            // Fermer la connexion avant de rediriger
            $conn->close();

            // Définir un message de succès pour la page suivante
            session_start();
            $_SESSION['success_message'] = "Inscription réussie !";

            // Redirection après l'inscription réussie
            header("Location: project.php");
            exit();  // Arrêter l'exécution du script pour éviter d'afficher un contenu supplémentaire
        } else {
            $error_message = "Erreur : " . $stmt->error;
        }

        // Fermer le statement
        $stmt->close();
    }

    // Fermer le statement de vérification des doublons
    $stmt_check->close();
}
?>


<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8" />
    <title>SITE de connexion</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #4E92FF, #0e6251, #FFFFFF);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);  /* Fond sombre semi-transparent */
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
            max-width: 600px;
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

        h2 {
            margin-bottom: 30px;
            color: #333;
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
            background: #003f73;
        }

        .login-img {
            width: 250px;
            height: auto;
            margin-right: 40px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 14px;
            margin-top: 10px;
            color: #0056B3;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="division">
    <img src="log.avif" alt="log" class="login-img">

    <div class="login-box">
        <h2>Student Inscription</h2>
        <form method="POST">
            <div>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div>
                <input type="text" name="log" placeholder="Login" required>
            </div>
            <div>
                <input type="password" name="pass" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="login-btn">S'inscrire</button>
            <a href="#" class="forgot-password">Mot de passe oublié ?</a>
        </form>

        <?php
        // Affichage du message d'erreur ou de succès
        if (isset($_SESSION['success_message'])) {
            echo "<p style='color: green; text-align: center;'>".$_SESSION['success_message']."</p>";
            unset($_SESSION['success_message']);  // Supprimer le message après affichage
        }

        if ($error_message) {
            echo "<p style='color: red; text-align: center;'>$error_message</p>";
        }
        ?>

    </div>
</div>

</body>
</html>




