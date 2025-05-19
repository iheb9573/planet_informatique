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
        .search-container {
            margin: 20px 0;
            max-width: 500px;
        }
        .search-input {
            border-radius: 25px;
            padding: 10px 20px;
            border: 2px solid #ddd;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: #0061f2;
            box-shadow: 0 0 10px rgba(0,97,242,0.2);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Ajouter la barre de recherche -->
        <div class="search-container mx-auto">
            <form class="d-flex" method="GET" action="">
                <input type="text" 
                       name="search" 
                       class="form-control search-input" 
                       placeholder="Rechercher un produit..."
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
  <h2 class="mb-4">Nos Produits</h2>
  <a href="panier.php" class="btn btn-primary mb-3">Voir le Panier</a>
  <a href="../index.php" class="btn btn-primary mb-3">Continuer vos achats</a>
  <div class="row">
      <?php
      // Modifier la requête SQL pour inclure la recherche
      $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
      $stmt = $pdo->prepare("SELECT * FROM produits WHERE nom LIKE ? OR description LIKE ?");
      $stmt->execute([$search, $search]);
      $produits = $stmt->fetchAll();
      ?>

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
</div>
</body>
</html>
