<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Planet Informatique' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="<?= $basePath ?? '' ?>assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= $basePath ?? '' ?>index.php">
        <i class="fas fa-laptop-code me-2"></i>Planet Informatique
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= $basePath ?? '' ?>index.php">
              <i class="fas fa-home me-1"></i> Accueil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $basePath ?? '' ?>pages/produits.php">
              <i class="fas fa-shopping-bag me-1"></i> Produits
            </a>
          </li>
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $basePath ?? '' ?>admin/dashboard.php">
              <i class="fas fa-tachometer-alt me-1"></i> Administration
            </a>
          </li>
          <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
          <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $basePath ?? '' ?>pages/panier.php">
              <i class="fas fa-shopping-cart me-1"></i> Panier
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-1"></i> <?= $_SESSION['nom'] ?? 'Mon compte' ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= $basePath ?? '' ?>pages/profile.php">Mon profil</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?? '' ?>pages/historique.php">Mes commandes</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?= $basePath ?? '' ?>logout.php">Déconnexion</a></li>
            </ul>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>