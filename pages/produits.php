<?php
session_start();
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM produits ORDER BY date_ajout DESC");
$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Produits - Planet Informatique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-img-top { height: 180px; object-fit: cover; }
  </style>
</head>
<body>
<div class="container mt-4">
  <h2 class="mb-4">Nos Produits</h2>
  <a href="panier.php" class="btn btn-primary mb-3">Voir le Panier</a>
  <div class="row">
    <?php foreach ($produits as $p): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
          <img src="../<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nom']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($p['nom']) ?></h5>
            <p class="card-text"><?= substr($p['description'], 0, 100) ?>...</p>
            <p class="fw-bold"><?= $p['prix'] ?> DT</p>
            <a href="ajouter_panier.php?id=<?= $p['id'] ?>" class="btn btn-success">Ajouter au Panier</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
