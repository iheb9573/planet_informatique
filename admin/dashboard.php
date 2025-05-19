<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

// Définir le titre de la page et le chemin de base
$pageTitle = 'Tableau de bord - Administration';
$basePath = '../';

// Récupérer les statistiques
// Nombre total de produits
$stmt = $pdo->query("SELECT COUNT(*) as total FROM produits");
$totalProduits = $stmt->fetch()['total'];

// Nombre total d'utilisateurs
$stmt = $pdo->query("SELECT COUNT(*) as total FROM utilisateurs");
$totalUtilisateurs = $stmt->fetch()['total'];

// Nombre total de commandes
$stmt = $pdo->query("SELECT COUNT(*) as total FROM commandes");
$totalCommandes = $stmt->fetch()['total'];

// Montant total des ventes
$stmt = $pdo->query("SELECT SUM(total) as total FROM commandes");
$totalVentes = $stmt->fetch()['total'] ?? 0;

// Dernières commandes
$stmt = $pdo->query("SELECT c.*, u.nom FROM commandes c JOIN utilisateurs u ON c.user_id = u.id ORDER BY c.date_commande DESC LIMIT 5");
$dernieresCommandes = $stmt->fetchAll();

// Derniers utilisateurs inscrits
$stmt = $pdo->query("SELECT * FROM utilisateurs ORDER BY date_creation DESC LIMIT 5");
$derniersUtilisateurs = $stmt->fetchAll();

// Inclure le header
include_once '../includes/header.php';
?>

<div class="admin-dashboard">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord</h1>
      <div>
        <a href="produits.php" class="btn btn-primary me-2">
          <i class="fas fa-shopping-bag me-1"></i> Gérer les produits
        </a>
        <a href="commandes.php" class="btn btn-success">
          <i class="fas fa-clipboard-list me-1"></i> Gérer les commandes
        </a>
      </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <div class="dashboard-card bg-primary text-white">
          <div class="card-icon">
            <i class="fas fa-shopping-cart fa-3x"></i>
          </div>
          <div class="card-content">
            <h3><?= number_format($totalVentes, 2) ?> DT</h3>
            <p>Ventes totales</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-card bg-success text-white">
          <div class="card-icon">
            <i class="fas fa-clipboard-list fa-3x"></i>
          </div>
          <div class="card-content">
            <h3><?= $totalCommandes ?></h3>
            <p>Commandes</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-card bg-info text-white">
          <div class="card-icon">
            <i class="fas fa-users fa-3x"></i>
          </div>
          <div class="card-content">
            <h3><?= $totalUtilisateurs ?></h3>
            <p>Utilisateurs</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-card bg-warning text-white">
          <div class="card-icon">
            <i class="fas fa-box-open fa-3x"></i>
          </div>
          <div class="card-content">
            <h3><?= $totalProduits ?></h3>
            <p>Produits</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Dernières commandes -->
      <div class="col-lg-7">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Dernières commandes</h5>
              <a href="commandes.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($dernieresCommandes) > 0): ?>
                    <?php foreach ($dernieresCommandes as $commande): ?>
                      <tr>
                        <td>#<?= $commande['id'] ?></td>
                        <td><?= htmlspecialchars($commande['nom']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></td>
                        <td><?= number_format($commande['total'], 2) ?> DT</td>
                        <td>
                          <a href="commande_details.php?id=<?= $commande['id'] ?>" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center py-3">Aucune commande trouvée</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Derniers utilisateurs -->
      <div class="col-lg-5">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-users me-2"></i> Nouveaux utilisateurs</h5>
              <a href="utilisateurs.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($derniersUtilisateurs) > 0): ?>
                    <?php foreach ($derniersUtilisateurs as $utilisateur): ?>
                      <tr>
                        <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($utilisateur['date_creation'])) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center py-3">Aucun utilisateur trouvé</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Liens rapides -->
    <div class="row g-4 mt-4">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-link me-2"></i> Accès rapides</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-3">
                <a href="produits.php" class="quick-link-card">
                  <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                  <h5>Produits</h5>
                  <p class="mb-0">Gérer les produits</p>
                </a>
              </div>
              <div class="col-md-3">
                <a href="commandes.php" class="quick-link-card">
                  <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                  <h5>Commandes</h5>
                  <p class="mb-0">Gérer les commandes</p>
                </a>
              </div>
              <div class="col-md-3">
                <a href="utilisateurs.php" class="quick-link-card">
                  <i class="fas fa-users fa-2x mb-2"></i>
                  <h5>Utilisateurs</h5>
                  <p class="mb-0">Gérer les utilisateurs</p>
                </a>
              </div>
              <div class="col-md-3">
                <a href="stats.php" class="quick-link-card">
                  <i class="fas fa-chart-bar fa-2x mb-2"></i>
                  <h5>Statistiques</h5>
                  <p class="mb-0">Voir les statistiques</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// Inclure le footer
include_once '../includes/footer.php';
?>

<!DOCTYPE html>
<html lang="fr"
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Contenu du dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
