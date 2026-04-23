<?php
require 'conn.php';

// Récupération des données envoyées par le formulaire
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$filiere = $_POST['filiere'] ?? '';

// Validation des données
if (empty($nom) || empty($prenom) || empty($filiere)) {
    die("Erreur : Tous les champs sont obligatoires.");
}

// Insertion dans la base de données avec requête préparée
$sql = "INSERT INTO etudiants (nom_etu, prenom_etu, id_fil) VALUES (:nom, :prenom, :filiere)";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
$stmt->bindParam(':filiere', $filiere, PDO::PARAM_INT);

$stmt->execute();

// Redirection vers la page principale
header("Location: index.php");
exit;
?>