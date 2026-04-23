<?php
require 'conn.php';

// Vérification que l'ID est présent et valide
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erreur : ID de l'étudiant manquant.");
}

$id = $_GET['id'];

// Suppression avec requête préparée
$sql = "DELETE FROM etudiants WHERE id_etu = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Redirection vers la page principale
header("Location: index.php");
exit;
?>