<?php
try {
// Paramètres de la base de données
$host = 'localhost';
$user = 'root';
$password_db = ''; // Ou votre mot de passe si nécessaire
$dbname = 'university';  // Le nom de votre base de données

// Connexion à la base de données avec PDO
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password_db);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
echo "Erreur de connexion : " . $e->getMessage();
}?>
