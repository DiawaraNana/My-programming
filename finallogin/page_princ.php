<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0e6251 , #FFFFFF,  #5499c7);
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
            background:#1f618d;
            border-radius: 15px;
            padding: 30px 40px;
            width: 100%;
            max-width: 800px;
            height: 800px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
            position: relative;
        }

        h2 {
            margin-bottom: 30px;
            color: #0b5345;
            background-color: #FFFFFF;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            font-family: "Times New Roman";
            letter-spacing: 2px;
            margin-bottom: 50px;
        }

        .division:hover {
            transform: translateY(-10px);
        }

        input {
            border-radius: 10px;
            height: 50px;
            width: 100%;
            margin-top: 15px;
            padding: 0 15px;
            font-size: 18px;
            border: 1px solid #ddd;
            font-family: "Times New Roman";
            outline: none;
            transition: all 0.3s ease;
        }

        input:hover {
            border-color: #0056B3;
            background-color: #0b5345;
        }

        .login-box {
            text-align: center;
            width: 100%;
        }

        /* Positionner l'image en haut à droite */
        .uemf-img {
            position: absolute;
            top: 20px;
            left: 50%;
            width: 300px;
            height: 200px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateX(-50%); /* Déplace l'image de moitié de sa largeur */
        }

    </style>
</head>
<body>

<div class="division">
    <img src="euromed.jpg" alt="log" class="uemf-img">

    <div class="login-box">
        <h2>Menu principal</h2>
        <form method="POST" action="">
            <div>
                <a href="table_etudiants.php">
                    <input type="button" value="Afficher étudiants">
                </a>
            </div>
            <div>
                <a href="ajout_etudiant.php">
                    <input type="button" value="Ajouter étudiants">
                </a>
            </div>
            <div>
                <a href="table_ecole.php">
                    <input type="button" value="Afficher écoles">
                </a>
            </div>
            <div>
                <a href="ajout_ecole.php">
                    <input type="button" value="Ajouter  école">
                </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
