<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: commandes.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT c.*, u.nom, u.email, u.adresse FROM commandes c JOIN utilisateurs u ON c.user_id = u.id WHERE c.id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch();

if (!$commande) {
    header('Location: commandes.php');
    exit;
}

// Récupérer les articles de la commande
$stmt = $pdo->prepare("SELECT p.*, pa.quantité FROM panier pa 
                      JOIN produits p ON pa.produit_id = p.id 
                      WHERE pa.command_id = ?");
$stmt->execute([$id]);
$articles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container py-4">
        <h1 class="mb-4">Détails de la Commande #<?= $commande['id'] ?></h1>
        <a href="commandes.php" class="btn btn-secondary mb-3">Retour à la liste des commandes</a>
        
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Informations client</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nom du Client</th>
                        <td><?= htmlspecialchars($commande['nom']) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($commande['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td><?= htmlspecialchars($commande['adresse']) ?></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td><?= $commande['total'] ?> DT</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><?= $commande['date_commande'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Articles commandés</h4>
            </div>
            <div class="card-body">
                <?php if (count($articles) > 0): ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Image</th>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articles as $article): ?>
                                <tr>
                                    <td><img src="../<?= $article['image'] ?>" width="60" class="img-thumbnail"></td>
                                    <td><?= htmlspecialchars($article['nom']) ?></td>
                                    <td><?= $article['prix'] ?> DT</td>
                                    <td><?= $article['quantité'] ?></td>
                                    <td><?= $article['prix'] * $article['quantité'] ?> DT</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total</strong></td>
                                <td><strong><?= $commande['total'] ?> DT</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning">Aucun article trouvé pour cette commande.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
