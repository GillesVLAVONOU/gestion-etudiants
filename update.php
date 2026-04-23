<?php
require 'conn.php';

// Vérification que l'ID est présent
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erreur : ID de l'étudiant manquant.");
}

$id = $_GET['id'];

// Récupération de l'étudiant à modifier
$sql = "SELECT id, nom, prenom, id_filiere FROM etudiants WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
}

// Récupération des filières pour le select
$stmt = $pdo->query("SELECT id, nom FROM filieres");
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $filiere = $_POST['filiere'] ?? '';

    if (empty($nom) || empty($prenom) || empty($filiere)) {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $sql = "UPDATE etudiants SET nom = :nom, prenom = :prenom, id_filiere = :filiere WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':filiere', $filiere, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Étudiant</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Modifier un Étudiant</h1>
    
    <?php if (isset($erreur)): ?>
        <p class="erreur"><?php echo htmlspecialchars($erreur); ?></p>
    <?php endif; ?>

    <form action="update.php?id=<?php echo $id; ?>" method="post" onsubmit="return validerFormulaire()">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($etudiant['nom']); ?>" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($etudiant['prenom']); ?>" required><br><br>

        <label for="filiere">Filière:</label>
        <select id="filiere" name="filiere" required>
            <option value="">Sélectionnez une filière</option>
            <?php foreach ($filieres as $f): ?>
                <option value="<?php echo $f['id']; ?>" <?php echo ($f['id'] == $etudiant['id_filiere']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($f['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Mettre à jour</button>
        <a href="index.php" class="btn-annuler">Annuler</a>
    </form>
</body>
</html>
