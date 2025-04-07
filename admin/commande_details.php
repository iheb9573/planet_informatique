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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Détails de la Commande #<?= $commande['id'] ?></h1>
    <a href="commandes.php" class="btn btn-secondary mb-3">Retour à la liste des commandes</a>
    <table class="table table-bordered">
        <tr>
            <th>Nom du Client</th>
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
</body>
</html>
