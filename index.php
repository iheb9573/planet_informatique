<?php
require_once 'config/db.php';

$stmt = $pdo->query("SELECT * FROM produits ORDER BY date_ajout DESC");
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planet Informatique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Planet Informatique</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="pages/panier.php">Voir Panier</a></li>
        <li class="nav-item"><a class="nav-link" href="pages/order.php">Passer une Commande</a></li>
        <li class="nav-item"><a class="nav-link" href="pages/login.php">Connexion</a></li>
        <li class="nav-item"><a class="nav-link" href="pages/register.php">Inscription</a></li>
        <li class="nav-item"><a class="nav-link" href="pages/profile.php">Voir Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="pages/historique.php">Historique</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<header class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-4">Bienvenue sur Planet Informatique</h1>
        <p class="lead">Votre boutique en ligne de matériel informatique</p>
    </div>
</header>

<!-- Produits Exemple -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Nos Produits</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">

      <!-- Carte produit 1 -->
      <?php foreach ($produits as $produit): ?>
      <div class="col">
        <div class="card h-100">
          <img src="<?= $produit['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($produit['description']) ?></p>
          </div>
          <div class="card-footer text-end">
            <strong><?= $produit['prix'] ?> DT</strong>
            <a href="ajouter_panier.php?id=<?= $produit['id'] ?>" class="btn btn-primary btn-sm">Ajouter au Panier</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">© 2025 Planet Informatique. Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>