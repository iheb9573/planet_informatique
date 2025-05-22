<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Récupérer les produits depuis la table panier
$stmt = $pdo->prepare("
    SELECT p.id, p.nom, p.prix AS prix_unitaire, pa.quantité, (p.prix * pa.quantité) AS total
    FROM panier pa
    JOIN produits p ON pa.produit_id = p.id
    WHERE pa.command_id IS NULL AND pa.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$articles = $stmt->fetchAll();

// Calculer le montant total
$total = 0;
foreach ($articles as $article) {
    $total += $article['total'];
}

// Traitement pour supprimer un article
if (isset($_GET['supprimer']) && is_numeric($_GET['supprimer'])) {
    $produit_id = $_GET['supprimer'];
    $stmt = $pdo->prepare("DELETE FROM panier WHERE produit_id = ? AND user_id = ? AND command_id IS NULL");
    $stmt->execute([$produit_id, $_SESSION['user_id']]);
    header('Location: panier.php');
    exit;
}

// Traitement pour vider le panier
if (isset($_GET['vider'])) {
    $stmt = $pdo->prepare("DELETE FROM panier WHERE user_id = ? AND command_id IS NULL");
    $stmt->execute([$_SESSION['user_id']]);
    header('Location: panier.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse = $_POST['adresse']; // Récupérer l'adresse saisie par l'utilisateur
    // Insérer une commande et associer les articles du panier
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO commandes (user_id, total, adresse, date_commande) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $total, $adresse]);
        $commandId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("UPDATE panier SET command_id = ? WHERE user_id = ? AND command_id IS NULL");
        $stmt->execute([$commandId, $_SESSION['user_id']]);

        $pdo->commit();
        $_SESSION['message'] = "Commande passée avec succès.";
        header('Location: confirmation.php');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Erreur lors du passage de la commande.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - Planet Informatique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4">Votre Panier</h2>
        <a href="produits.php" class="btn btn-primary mb-3">Continuer vos achats</a>
        
        <?php if (count($articles) > 0): ?>
            <a href="panier.php?vider=1" class="btn btn-danger mb-3" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">
                <i class="fas fa-trash-alt"></i> Vider le panier
            </a>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?= htmlspecialchars($article['nom']) ?></td>
                                <td><?= $article['prix_unitaire'] ?> DT</td>
                                <td><?= $article['quantité'] ?></td>
                                <td><?= $article['total'] ?> DT</td>
                                <td>
                                    <a href="panier.php?supprimer=<?= $article['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td colspan="2" class="fw-bold"><?= $total ?> DT</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="../valider_commande.php" class="btn btn-success">Valider la commande</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Votre panier est vide.</div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
