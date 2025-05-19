<?php
session_start();
require_once 'config/db.php';

// Définir le titre de la page et le chemin de base
$pageTitle = 'Accueil - Planet Informatique';
$basePath = '';

// Récupérer les produits en vedette
$stmt = $pdo->query("SELECT * FROM produits ORDER BY id DESC LIMIT 8");
$produits = $stmt->fetchAll();

// Inclure le header
include_once 'includes/header.php';
?>

<!-- Hero Section avec Carousel -->
<div class="hero-section">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" style="max-height: 500px; overflow: hidden;">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/images/banner1.jpg" class="d-block w-100" alt="Offres spéciales">
        <div class="carousel-caption">
          <h2 class="display-4 fw-bold">Bienvenue chez Planet Informatique</h2>
          <p class="lead">Découvrez notre sélection de produits high-tech à prix imbattables</p>
          <a href="pages/produits.php" class="btn btn-primary btn-lg">Voir les produits</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/banner5.png" class="d-block w-100" alt="Nouveautés">
        <div class="carousel-caption">
          <h2 class="display-4 fw-bold">Nouveautés 2023</h2>
          <p class="lead">Les dernières innovations technologiques sont arrivées</p>
          <a href="pages/produits.php" class="btn btn-primary btn-lg">Découvrir</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/banner4.png" class="d-block w-100" alt="Services">
        <div class="carousel-caption">
          <h2 class="display-4 fw-bold">Service après-vente</h2>
          <p class="lead">Une équipe d'experts à votre service</p>
          <a href="#" class="btn btn-primary btn-lg">Nous contacter</a>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Suivant</span>
    </button>
  </div>
</div>

<!-- Section Catégories -->
<section class="categories-section py-5">
  <div class="container">
    <h2 class="section-title text-center mb-5">Nos Catégories</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-laptop fa-3x"></i>
          </div>
          <h3>Ordinateurs</h3>
          <p>Découvrez notre gamme d'ordinateurs portables et de bureau</p>
          <a href="#" class="btn btn-outline-primary">Explorer</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-mobile-alt fa-3x"></i>
          </div>
          <h3>Smartphones</h3>
          <p>Les derniers smartphones des meilleures marques</p>
          <a href="#" class="btn btn-outline-primary">Explorer</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-headphones fa-3x"></i>
          </div>
          <h3>Accessoires</h3>
          <p>Tous les accessoires pour compléter votre équipement</p>
          <a href="#" class="btn btn-outline-primary">Explorer</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Produits en vedette -->
<section class="featured-products py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center mb-5">Produits en vedette</h2>
    
    <?php
    // Récupérer tous les produits sans limite
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY id DESC");
    $produits = $stmt->fetchAll();
    
    if (count($produits) > 0):
    ?>
      <div class="row g-4">
        <?php foreach ($produits as $produit): ?>
          <div class="col-md-3 mb-4">
            <div class="card product-card h-100">
              <div class="product-image-container">
                <img src="<?= $produit['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>">
              </div>
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                <p class="card-text product-price"><?= $produit['prix'] ?> DT</p>
                <p class="card-text description-truncate"><?= htmlspecialchars(substr($produit['description'], 0, 100)) ?>...</p>
              </div>
              <div class="card-footer bg-white">
                <div class="d-flex justify-content-between">
                  <!-- Suppression du bouton Détails -->
                  <a href="pages/ajouter_panier.php?id=<?= $produit['id'] ?>" class="btn btn-sm btn-primary w-100">
                    <i class="fas fa-shopping-cart me-1"></i> Ajouter au panier
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- SUPPRIMER ce bloc -->
      <!--
      <div class="text-center mt-5">
        <a href="pages/produits.php" class="btn btn-lg btn-primary">Voir tous les produits</a>
      </div>
      -->
    <?php else: ?>
      <p class="text-center">Aucun produit disponible pour le moment.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Section Avantages -->
<section class="features-section py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card text-center">
          <div class="feature-icon mb-3">
            <i class="fas fa-truck fa-3x"></i>
          </div>
          <h3>Livraison rapide</h3>
          <p>Livraison en 24-48h sur tout le territoire</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center">
          <div class="feature-icon mb-3">
            <i class="fas fa-shield-alt fa-3x"></i>
          </div>
          <h3>Garantie 2 ans</h3>
          <p>Tous nos produits sont garantis 2 ans minimum</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center">
          <div class="feature-icon mb-3">
            <i class="fas fa-headset fa-3x"></i>
          </div>
          <h3>Support 7j/7</h3>
          <p>Notre équipe est à votre service tous les jours</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
// Inclure le footer
include_once 'includes/footer.php';
?>