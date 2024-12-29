<?php // supprimer_etudiant.php
include('db_connect.php');

// Vérifier si l'ID de l'étudiant est passé via l'URL
if (isset($_GET['id_etudiant'])) {
$id_etudiant = $_GET['id_etudiant'];

// Requête pour supprimer l'étudiant
$query = "DELETE FROM etudiant_in_u WHERE id_etudiant = :id_etudiant";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_etudiant', $id_etudiant);
$stmt->execute();

echo "Étudiant supprimé avec succès.";
// Rediriger vers la liste des étudiants après suppression
header('Location: table_etudiants.php');
} else {
echo "Aucun étudiant spécifié.";
}?>
