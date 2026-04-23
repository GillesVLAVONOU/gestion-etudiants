<?php
require 'conn.php';

// Récupération des filières
$stmt = $pdo->query("SELECT id, nom FROM filieres");
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Étudiants</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Ajouter un Étudiant</h1>
    <form action="traitement.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        <label for="filiere">Filière:</label>
        <select id="filiere" name="filiere" required>
            <option value="">Sélectionnez une filière</option>
            <?php foreach ($filieres as $filiere): ?>
                <option value="<?php echo $filiere['id']; ?>"><?php echo $filiere['nom']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>