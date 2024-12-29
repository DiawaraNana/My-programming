<?php // supprimer_etudiant.php
include('db_connect.php');

// Vérifier si l'ID de l'étudiant est passé via l'URL
if (isset($_GET['id_ecole'])) {
    $id_etablissement = $_GET['id_ecole'];

// Requête pour supprimer l'étudiant
    $query = "DELETE FROM etablissement WHERE id_ecole= :id_ecole";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_ecole', $id_etablissement);
    $stmt->execute();

    echo "Établissement supprimé avec succès.";
// Rediriger vers la liste des étudiants après suppression
    header('Location: table_ecole.php');
} else {
    echo "Aucun établissement spécifié.";
}?>