<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    $_SESSION['message'] = "Accès refusé. Cette page est réservée aux administrateurs.";
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT c.*, u.email FROM commandes c JOIN utilisateurs u ON c.user_id = u.id ORDER BY c.date_commande DESC");
$commandes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commandes - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1 class="mb-4">Commandes Clients</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Retour au Dashboard</a>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Total</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['email'] ?></td>
                <td><?= $c['total'] ?> DT</td>
                <td><?= $c['date_commande'] ?></td>
                <td>
                    <a href="commande_details.php?id=<?= $c['id'] ?>" class="btn btn-info btn-sm">Voir Détails</a>
                    <a href="supprimer_commande.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette commande ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
