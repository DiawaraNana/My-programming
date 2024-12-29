

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        html, body {
            height: 100%; /* Assure que le body occupe toute la hauteur de la fenêtre */
            margin: 0; /* Supprime les marges par défaut */
        }

        /* Structure du body pour flexbox */
        .body {
            font-family: "Courier New", monospace;
            font-size: 20px;
            text-align: center;
            display: flex; /* Flexbox pour aligner les éléments horizontalement */
            justify-content: center; /* Centrer les éléments horizontalement */
            align-items: center; /* Centrer les éléments verticalement */
            height: 100vh; /* Prendre toute la hauteur de la fenêtre */
            background: linear-gradient(135deg, #6a5acd, #2c3e50, #ecf0f1);

            margin: 0;
        }

        /* Conteneur de la division, flexbox pour aligner image et formulaire */
        .division {

            justify-content: center; /* Centrer les éléments horizontalement */
            align-items: center; /* Centrer verticalement */
            background-color: #002752; /* Couleur de fond */
            border: 3px solid #2c3e50;
            border-radius: 15px;
            padding: 20px;
            width: 500px; /* Largeur du conteneur */
            height: 500px; /* Hauteur du conteneur */
        }

        /* Style du titre .head pour qu'il soit centré dans la division */
        .head {
            color: #dee1ff;
            font-size: 30px;
            background-color: #85c1e9;
            margin-bottom: 20px;
            border: 3px solid #2c3e50;
            width: 50%;
            text-align: center; /* Centrer le texte */
            border-radius: 10px;
            padding: 10px 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
            align-items: center;
            margin-left: 100px;
            font-family: "Times New Roman";
        }

        /* Style pour l'image */
        /*img {
            width: 150px;
            height: 150px;
            margin-right: 20px;
        }*/

        /* Style du formulaire */
        form {
            display: flex;
            flex-direction: column; /* Organiser les éléments du formulaire verticalement */
            justify-content: center;
            align-items: center; /* Centrer le formulaire */
        }

        /* Style des autres éléments de formulaire */
        .h {
            font-size: 20px;
            margin-top: 10px;
            font-family: "Times New Roman";
            color: #dee1ff;
        }

        input {
            border-radius: 10px;
            height: 30px;
            width: 170px;
            margin-top: 10px;
        }
        input:focus {
            border-color: #0056B3;
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
        }

    </style>
</head>
<body class="body">

<div class="division">
    <div class="head">CONNEXION</div>

    <!-- Image à gauche -->
    <!--img src="im.png" alt="Logo"-->

    <!-- Formulaire à droite -->
    <form method="post" action="">
        <div class="h"><b>Nom</b></div>
        <input type="text" name="Nom"/>
        <div class="h"><b>Prénom</b></div>
        <input type="text" name="Prénom"/>
        <div class="h"><b>Mot de passe</b></div>
        <input type="password" name="pass"/><br/><br/><br/>
        <input type="submit" name="valider" value="Vérifier"/><br/>
    </form><br/>

<?php
session_start();
@$prenom=$_POST["Prénom"];
@$nom=$_POST["Nom"];
@$mot_pass=$_POST["pass"];
@$valider=$_POST["valider"];
@$message="";
@$Nom_c="DIAWARA";
@$Prenom_c="Nana";
@$pass_c="hana*";
if(isset($valider)==NULL){
    echo "";
}

elseif (isset($valider)==true){
    if($prenom==$Prenom_c && $nom==$Nom_c && $mot_pass==$pass_c){
        $_SESSION["autoriser"]="oui";
        echo "<br/>Vous etes bien connecté!";
    }
    else{
        $message="<br/>Entrez les informations correctes!";
        echo "<br/>$message";
    }

}session_destroy();?>
</div>
</body>
</html>
