<?php
session_start();
require_once '../config/db.php';

// Définir le titre de la page et le chemin de base
$pageTitle = 'Détails de la commande - Planet Informatique';
$basePath = '../';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: historique.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT c.* FROM commandes c WHERE c.id = ? AND c.user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$commande = $stmt->fetch();

if (!$commande) {
    header('Location: historique.php');
    exit;
}

// Récupérer les articles de la commande
$stmt = $pdo->prepare("SELECT p.*, pa.quantité FROM panier pa 
                      JOIN produits p ON pa.produit_id = p.id 
                      WHERE pa.command_id = ?");
$stmt->execute([$id]);
$articles = $stmt->fetchAll();

// Inclure le header
include_once '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="historique.php">Mes commandes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Commande #<?= $commande['id'] ?></li>
                </ol>
            </nav>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0"><i class="fas fa-receipt me-2"></i>Détails de la commande #<?= $commande['id'] ?></h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2">Informations de la commande</h5>
                            <p><strong>Date :</strong> <?= date('d/m/Y à H:i', strtotime($commande['date_commande'])) ?></p>
                            <p><strong>Montant total :</strong> <?= $commande['total'] ?> DT</p>
                            <p><strong>Statut :</strong> <span class="badge bg-success">Confirmée</span></p>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-3">Articles commandés</h5>
                    <?php if (count($articles) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($articles as $article): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="../<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>" class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <span><?= htmlspecialchars($article['nom']) ?></span>
                                                </div>
                                            </td>
                                            <td><?= $article['prix'] ?> DT</td>
                                            <td><?= $article['quantité'] ?></td>
                                            <td class="fw-bold"><?= $article['prix'] * $article['quantité'] ?> DT</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td class="fw-bold"><?= $commande['total'] ?> DT</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Aucun article trouvé pour cette commande.
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="historique.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour à mes commandes
                        </a>
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