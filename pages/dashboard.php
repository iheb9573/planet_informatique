<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de Bord - Planet Informatique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .stats-container {
            padding: 2rem 0;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .stats-value {
            font-size: 2rem;
            font-weight: bold;
            color: #0061f2;
        }
    </style>
</head>
<body>
    <div class="container stats-container">
        <h2 class="mb-4">Tableau de bord des statistiques</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card">
                    <h4>Total Utilisateurs</h4>
                    <div class="stats-value"><?= $total_users ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h4>Total Produits</h4>
                    <div class="stats-value"><?= $total_products ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h4>Total Commandes</h4>
                    <div class="stats-value"><?= $total_orders ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h4>Revenu Total (DT)</h4>
                    <div class="stats-value"><?= number_format($total_revenue, 2) ?></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
