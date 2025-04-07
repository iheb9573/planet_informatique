<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM produits ORDER BY date_ajout DESC");
$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Produits - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>Liste des Produits</h2>
<a href="produits_ajout.php" class="btn btn-success mb-3">Ajouter Produit</a>
<a href="dashboard.php" class="btn btn-secondary">Retour au Dashboard</a>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Image</th><th>Nom</th><th>Prix</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($produits as $p): ?>
    <tr>
      <td><img src="../../<?= $p['image'] ?>" width="60"></td>
      <td><?= $p['nom'] ?></td>
      <td><?= $p['prix'] ?> DT</td>
      <td>
        <a href="produits_edit.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
        <a href="produits_delete.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</body>
</html>
