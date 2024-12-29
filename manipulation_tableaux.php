<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>MANAGEMENT DES ETUDIANTS</title>
    <style>

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 230vh; /* Assure que le body occupe toute la hauteur de la fenêtre */
            position: relative; /* Nécessaire pour le positionnement de ::before */
            overflow-x: hidden;
            margin: 0 auto;
            align-content: center;


        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("bg4.jpg");
            background-size: cover;
            background-position: center;
            z-index: -1;
            opacity: 0.5;

        }

        h1{

            font-family: "Times New Roman", serif;
            font-size: 30px;
            color: #004c96 ;
            text-align: center;
            margin-top: 50px;
            margin: 0 auto;
        }

        table {
            width: 100%; /* Utilisez 100% de la largeur disponible */
            max-width: 2000px;
            border-collapse: collapse; /* Evite les doubles bordures entre les cellules */
            margin: 0 auto;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

        }
        * {
            box-sizing: border-box;
        }
        h2{

            font-family: "Arial", sans-serif;
            font-size: 20px;
            color: #ecf0f1 ;
            width: 100%; /* Utilisez 100% de la largeur disponible */
            max-width: 2000px;
            padding: 8px 12px;
            background-color: #5d6d7e ;
            margin: 0 auto;
            margin-top: 50px;
            text-align: center;

        }
        .container {
            font-family: "Courier New", monospace;
            font-size: 20px;
            align-content: center;
            text-align: center;
            background-color: #fff; /* Couleur du fond du cadre */
            border: 3px solid #2c3e50; /* Bordure autour du cadre */
            width: 50%; /* Largeur du cadre */
            height: fit-content;
            margin: 20px auto; /* Centrer le cadre et ajouter une marge */
            padding: 20px; /* Espacement interne du cadre */
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.3); /* Ombre autour du cadre */
            border-radius: 10px; /* Coins arrondis */
        }
        .container:hover{
            background-color: #5d6d7e;
        }

        thead, th  {
            height: 50px;
            background-color: #1b4f72 ;
            font-size: 15pt;
            color: #fdfefe;
            font-family: "Times New Roman", serif;

        }
        tr{
            background-color:  #aed6f1  ;
        }
        tr:hover {
            background-color: #2874a6; /* Couleur de fond lors du survol de la ligne entière */
        }


        td{
            width: fit-content;
            font-size: 12pt;
            font-family:"Times New Roman", serif;
            padding: 12px;
            border: 1px solid black;
            text-align: center;
            color: black;
        }

    </style>
</head>
<body >

<h1><u><i> LES TABLEAUX EN PHP</i></u></h1>
<h2>1.Tableau initial des étudiants</h2>

<?php
//$tab1=array("Karim","Maroua","Aya","Fatima","Mohamed");
$tab2=array(
    "Karim","Aya","Daniel","Maroua","Fatima"
);

echo "<table>";
echo "<thead><th>Index</th><th>Nom</th>";

foreach($tab2 as $index => $nom){
    echo "<tr><td>$index</td><td>$nom</td></tr>";
}
echo "</table><br>";
?>
<h2>2.Tableau des étudiants apres avoir ajouté Mohamed !</h2>

<?php
//$tab1=array("Karim","Maroua","Aya","Fatima","Mohamed");
$tab2[] = "Mohamed";
echo "<table>";
echo "<thead><th>Index</th><th>Nom</th>";

foreach($tab2 as $index => $nom){
    echo "<tr><td>$index</td><td>$nom</td></tr>";
}
echo "</table>";
?>

<h2>3.Tableau des étudiants apres avoir supprimé Karim!</h2>

<?php
//$tab1=array("Karim","Maroua","Aya","Fatima","Mohamed");
$premier = array_shift($tab2);
echo "<table>";
echo "<thead><th>Index</th><th>Nom</th>";

foreach($tab2 as $index => $nom){
    echo "<tr><td>$index</td><td>$nom</td></tr>";
}
echo "</table>";
?>
<h2>4.Vérifier si Mohamed est dans le tableau!</h2>
<?php
if (in_array("Mohamed", $tab2)) {
    echo " <br/><h3 class='container'>L'étudiant Mohamed  trouvé.</h3>";
} else {
    echo "<br/><h3 class='container'>Mohamed non trouvé.</h3>";}  ?>

<h2>5.Sorting array!</h2>
<?php
sort($tab2);
echo "<table>";
echo "<thead><th>Index</th><th>Nom</th>";
foreach ($tab2 as $index => $nom) {
    echo "<tr><td>$index</td><td>$nom</td></tr>";
}
echo "</table>";
?>

<h2>6. Tableau des étudiants après avoir inversé l'ordre du tableau!</h2>

<?php
// Utilisation du tableau trié avant inversion
$tab_inverse = array_reverse($tab2, true);
echo "<table>";
echo "<thead><th>Index</th><th>Nom</th>";
foreach ($tab_inverse as $index => $nom) {
    echo "<tr><td>$index</td><td>$nom</td></tr>";
}
echo "</table>";
?>
<h2>7.Tableau des étudiants avec leurs ages!</h2>
<?php

$tab1=array(
    "Aya"=>18,"Daniel"=>19,"Fatima"=>24,"Maroua"=>25,"Mohamed"=>16,
);
echo "<table>";
echo "<thead><th>Nom</th><th>Age</th>";

foreach($tab1 as $nom=> $age){
    echo "<tr><td>$nom</td><td>$age</td></tr>";
}
echo "</table>";
echo "<div class='container'>";  // Utilisation des guillemets simples pour éviter le conflit
foreach ($tab1 as $nom => $age) {
    echo "<br/><b>l'étudiant $nom a $age ans. </b>  <br/>";
}
echo "</div>";
?>


</body>
</html>