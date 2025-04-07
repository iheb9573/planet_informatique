<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

// Récupérer le produit à modifier
$produit = null;
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $produit = $stmt->fetch();
    
    if (!$produit) {
        header('Location: produits.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    // Gestion image
    $imagePath = $produit['image']; // Conserver l'image existante par défaut
    
    if (!empty($_FILES['image']['name'])) {
        // Supprimer l'ancienne image si elle existe
        if ($produit['image'] && file_exists('../../' . $produit['image'])) {
            unlink('../../' . $produit['image']);
        }
        
        // Uploader la nouvelle image
        $imgName = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/' . $imgName);
        $imagePath = 'uploads/' . $imgName;
    }

    $stmt = $pdo->prepare("UPDATE produits SET nom = ?, description = ?, prix = ?, image = ? WHERE id = ?");
    $stmt->execute([$nom, $description, $prix, $imagePath, $id]);

    header('Location: produits.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>Modifier le Produit</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $produit['id'] ?? '' ?>">
    
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($produit['nom'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($produit['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label>Prix</label>
        <input type="number" name="prix" step="0.01" class="form-control" value="<?= $produit['prix'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label>Image actuelle</label>
        <?php if (!empty($produit['image'])): ?>
            <img src="../../<?= $produit['image'] ?>" height="100" class="d-block mb-2">
        <?php else: ?>
            <p>Aucune image</p>
        <?php endif; ?>
        
        <label>Nouvelle image (laisser vide pour conserver l'actuelle)</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="produits.php" class="btn btn-secondary">Annuler</a>
</form>
</body>
</html>