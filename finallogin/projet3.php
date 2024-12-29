<?php
session_start();

// Informations utilisateur en dur
$bonuser = "nana";
$bonpass = "nana2";
$bonnum = "2200770"; // Exemple de matricule valide

// Récupération des données du formulaire
@$user = $_POST["nom"]; // Nom d'utilisateur saisi
@$pass = $_POST["pass"]; // Mot de passe saisi
@$num = $_POST["num"]; // Matricule saisi
@$valider = $_POST["valider"]; // Bouton de validation

// Initialisation des messages
$error_message = "";
$success_message = "";

if (isset($valider)) {
    if ($user === $bonuser && $pass === $bonpass && $num === $bonnum) {
        // Authentification réussie
        $_SESSION["autoriser"] = "oui";
        $_SESSION["username"] = $user; // Enregistrer le nom d'utilisateur dans la session
        $_SESSION['success_message'] = "Connexion réussie !";
        header("Location: page_princ.php"); // Redirection vers la page suivante
        exit();
    } else {
        // Authentification échouée
        $error_message = "Nom d'utilisateur, mot de passe ou matricule incorrect.";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style> body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(100deg,  #FFFFFF, #4E92FF,#145a32);
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
            max-width: 1000px;
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

        h2 {
            margin-bottom: 30px;
            color:#0056B3;
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
         input:hover {
              background-color:#0b5345 ;
color: aliceblue;
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
        }</style>
</head>
<body>


    <?php
    // Affichage des messages d'erreur ou de succès
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";



    }
    if (!empty($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    }
    ?>

    <div class="division">
        <img src="log.avif" alt="log" class="login-img">

        <div class="login-box">
            <h2>Student Login</h2>
            <form method="POST" action="">

                <div>
                    <input type="text" name="nom" placeholder="NOM" required>
                </div>
                <div>
                    <input type="password" name="pass" placeholder="Mot de passe" required>
                </div>
                <div>
                    <input type="text" name="num" placeholder="Matricule" required>
                </div>
                <input type="submit" name= "valider" value="Se connecter">
            </form>
        </div>
    </div>


</body>
</html>
