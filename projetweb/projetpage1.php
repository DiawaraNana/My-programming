<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zest Hotel Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("images.jpeg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            background-color: #ffffff;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 40px;
            overflow: hidden;
            height: 75%;
            width: 68%;
            max-width: 900px;
        }

        .left {
            opacity: 2.5;
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left h1 {
            font-size: 2rem;
            color: darkgreen;
            margin-bottom: 10px;
        }

        .left p {
            color: black;
            margin-bottom: 30px;
        }

        .role-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .role-buttons button {
            flex: 1;
            background-color: #f0f0f0;
            color: #4CAF50;
            border: 1px solid #4CAF50;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .role-buttons button:hover {
            background-color: darkgreen;
            color: white;
        }

        .role-buttons .selected {
            background-color: darkgreen;
            color: white;
        }

        .left .form-group {
            margin-bottom: 20px;
        }

        .left label {
            display: block;
            margin-bottom: 5px;
            color: black;
        }

        .left input {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .left button {
            background-color: #bde314;
            color: black;
            border: none;
            padding: 10px;
            width: 40%;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .left button:hover {
            background-color: darkgreen;
        }

        .buttons {
            display: flex;
            justify-content: center;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }

        .right img {
            max-width: 100%;
            height: 100%;
        }

        .error-message {
            color: red;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
session_start();
@$user = $_POST["username"];
@$pass = $_POST["password"];
@$valider = $_POST["valider"];
@$role = $_POST["role"];

if (isset($valider)) {
    // Autoriser l'accès sans vérification des identifiants
    $_SESSION["autoriser"] = "oui";
    $_SESSION["client_name"] = $user; // Stocker le nom d'utilisateur (optionnel)

    // Rediriger en fonction du rôle sélectionné
    if ($role == 'client') {
        header("Location: menuclient.php");
        exit();
    } elseif ($role == 'admin') {
        header("Location: admin.php");
        exit();
    }
}
?>
<div class="container">
    <div class="left">
        <h1>Welcome to Zest Hotel </h1>
        <p>Enjoy your stay with us in the best budget hotel chain by SwissBell Hotel.</p>

        <div class="role-buttons">
            <button type="button" onclick="selectRole('client')">Client</button>
            <button type="button" onclick="selectRole('admin')">Administrator</button>
        </div>

        <form action="" method="POST" id="loginForm">
            <input type="hidden" id="roleInput" name="role" value="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>

            <div class="buttons">
                <button type="submit" name="valider">Login</button>
            </div>
        </form>
    </div>
    <div class="right">
        <img src="impaglog.PNG" alt="Promotional Image">
    </div>
</div>

<script>
    function selectRole(role) {
        document.getElementById('roleInput').value = role;
        document.querySelectorAll('.role-buttons button').forEach(button => button.classList.remove('selected'));
        if (role === 'client') {
            document.querySelector('.role-buttons button:nth-child(1)').classList.add('selected');
        } else {
            document.querySelector('.role-buttons button:nth-child(2)').classList.add('selected');
        }
    }
</script>
</body>
</html>