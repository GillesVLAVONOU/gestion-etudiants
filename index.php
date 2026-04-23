<?php
require 'conn.php';

// Récupération des filières
$stmt = $pdo->query("SELECT id_fil, lib_fil FROM filieres");
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des étudiants avec leur filière (jointure)
$sql = "SELECT e.id_etu, e.nom_etu, e.prenom_etu, f.lib_fil AS filiere 
        FROM etudiants e 
        JOIN filieres f ON e.id_fil = f.id_fil 
        ORDER BY e.nom_etu";
$stmt = $pdo->query($sql);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Étudiants</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
</head>
<body>
    <h1 class="titre-principal">Gestion des Étudiants</h1>
    <div class="container-global">
        <h2 class="titre-form">Ajouter un Étudiant</h2>
        <form action="traitement.php" method="post" class="form-etudiant">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required><br><br>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required><br><br>
            <label for="filiere">Filière:</label>
            <select id="filiere" name="filiere" required>
                <option value="">Sélectionnez une filière</option>
                <?php foreach ($filieres as $filiere): ?>
                    <option value="<?php echo $filiere['id_fil']; ?>"><?php echo htmlspecialchars($filiere['lib_fil']); ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <button type="submit">Ajouter</button>
        </form>

        <h2 class="titre-table">Liste des Étudiants</h2>
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
                    <td><?php echo htmlspecialchars($etudiant['nom_etu']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['prenom_etu']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['filiere']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $etudiant['id_etu']; ?>" class="btn-modifier">Modifier</a>
                        <a href="delete.php?id=<?php echo $etudiant['id_etu']; ?>" class="btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>