<?php
session_start();
require_once '../config/db.php';

// Définir le titre de la page et le chemin de base
$pageTitle = 'Historique des commandes - Planet Informatique';
$basePath = '../';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY date_commande DESC");
$stmt->execute([$_SESSION['user_id']]);
$commandes = $stmt->fetchAll();

// Inclure le header
include_once '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0"><i class="fas fa-history me-2"></i>Historique de mes commandes</h2>
                </div>
                <div class="card-body">
                    <?php if (count($commandes) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($commandes as $c): ?>
                                        <tr>
                                            <td>#<?= $c['id'] ?></td>
                                            <td><?= date('d/m/Y à H:i', strtotime($c['date_commande'])) ?></td>
                                            <td class="fw-bold"><?= $c['total'] ?> DT</td>
                                            <td>
                                                <span class="badge bg-success">Confirmée</span>
                                            </td>
                                            <td>
                                                <a href="commande_details.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Détails
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Vous n'avez pas encore passé de commande.
                        </div>
                        <a href="../pages/produits.php" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Inclure le footer
include_once '../includes/footer.php';
?>
