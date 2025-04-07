<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

// Fetch dashboard data
$totalProduits = $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn();
$totalCommandes = $pdo->query("SELECT COUNT(*) FROM commandes")->fetchColumn();
$totalRevenu = $pdo->query("SELECT SUM(total) FROM commandes")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    

    <h1 class="mb-4">Dashboard - Admin</h1>

    <!-- Navigation Buttons -->
    <div class="mb-4">
        <a href="produits_ajout.php" class="btn btn-success">Ajouter un Produit</a>
        <a href="produits.php" class="btn btn-primary">Gérer les Produits</a>
        <a href="commandes.php" class="btn btn-primary">Voir les Commandes</a>
        <a href="stats.php" class="btn btn-primary">Voir les Statistiques</a>
        <a href="utilisateurs.php" class="btn btn-info">Gérer les Utilisateurs</a> <!-- Bouton ajouté -->
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Produits</h5>
                    <p class="card-text"><?= $totalProduits ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Commandes</h5>
                    <p class="card-text"><?= $totalCommandes ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Revenu Total</h5>
                    <p class="card-text"><?= $totalRevenu ?> DT</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
