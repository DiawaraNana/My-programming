<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; // hôte
$dbname = 'hotel_management'; // nom de votre base de données
$username = 'root'; // nom d'utilisateur de votre base de données
$password = ''; // mot de passe de votre base de données

try {
    // Création de la connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur pour PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

