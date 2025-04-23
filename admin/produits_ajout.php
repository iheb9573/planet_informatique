<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    // Gestion image
    $imagePath = '';
    if ($_FILES['image']['name']) {
        $imgName = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/' . $imgName);
        $imagePath = 'uploads/' . $imgName;
    }

    $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $imagePath]);

    header('Location: produits.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<a href="dashboard.php" class="btn btn-secondary">Retour au Dashboard</a>
<h2>Ajouter un Produit</h2>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Prix</label>
        <input type="number" name="prix" step="0.01" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>
</body>
</html>
