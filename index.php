<?php
require 'conn.php';

// Récupération des filières
$stmt = $pdo->query("SELECT id, nom FROM filieres");
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des étudiants avec leur filière (jointure)
$sql = "SELECT e.id, e.nom, e.prenom, f.nom AS filiere 
        FROM etudiants e 
        JOIN filieres f ON e.id_filiere = f.id 
        ORDER BY e.nom";
$stmt = $pdo->query($sql);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <h2>Liste des Étudiants</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Filière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
            <tr>
                <td><?php echo htmlspecialchars($etudiant['nom']); ?></td>
                <td><?php echo htmlspecialchars($etudiant['prenom']); ?></td>
                <td><?php echo htmlspecialchars($etudiant['filiere']); ?></td>
                <td>
                    <a href="update.php?id=<?php echo $etudiant['id']; ?>" class="btn-modifier">Modifier</a>
                    <a href="delete.php?id=<?php echo $etudiant['id']; ?>" class="btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>