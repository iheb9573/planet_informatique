<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Récupérer les produits depuis la table panier
$stmt = $pdo->prepare("
    SELECT p.nom, p.prix AS prix_unitaire, pa.quantité, (p.prix * pa.quantité) AS total
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
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1 class="mb-4">Votre Panier</h1>
    <?php if (!empty($articles)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix Unitaire (DT)</th>
                    <th>Quantité</th>
                    <th>Total (DT)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article['nom']) ?></td>
                        <td><?= number_format($article['prix_unitaire'], 2) ?></td>
                        <td><?= $article['quantité'] ?></td>
                        <td><?= number_format($article['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="fw-bold">Montant total (DT): <?= number_format($total, 2) ?></p>
        <form method="POST" class="d-inline">
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse de livraison</label>
                <input type="text" name="adresse" id="adresse" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Passer une commande</button>
        </form>
        <a href="../index.php" class="btn btn-secondary">Continuer vos achats</a>
    <?php else: ?>
        <p>Votre panier est vide.</p>
        <a href="../index.php" class="btn btn-secondary">Continuer vos achats</a>
    <?php endif; ?>
</body>
</html>
