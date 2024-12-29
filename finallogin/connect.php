<?php
// Paramètres de connexion à la base de données
$host = 'localhost';
$user = 'root';
$password_db = '';  // Changez si vous avez un mot de passe pour MySQL
$dbname = 'formulaire';

// Créer la connexion
$conn = new mysqli($host, $user, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

?>
