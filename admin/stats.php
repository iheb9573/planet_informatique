<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

// Requête pour le graphique bar (revenus mensuels)
$data = $pdo->query("SELECT DATE_FORMAT(date_commande, '%Y-%m') as mois, SUM(total) as total FROM commandes GROUP BY mois")->fetchAll();
$labels = array_column($data, 'mois');
$totaux = array_column($data, 'total');

// KPIs
$totalUsers = $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM commandes")->fetchColumn();
$totalRevenue = $pdo->query("SELECT SUM(total) FROM commandes")->fetchColumn();

// Données pour le pie chart (actifs vs inactifs)
$activeUsers = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE actif = 1")->fetchColumn();
$inactiveUsers = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE actif = 0")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stats</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="container py-4">
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Retour au Dashboard</a>
    <h2 class="mb-4">Tableau de bord des statistiques</h2>

    <!-- KPIs -->
    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Utilisateurs</h5>
                <p class="display-6"><?= $totalUsers ?></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Produits</h5>
                <p class="display-6"><?= $totalProducts ?></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Commandes</h5>
                <p class="display-6"><?= $totalOrders ?></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Revenu Total (DT)</h5>
                <p class="display-6"><?= number_format($totalRevenue, 2, ',', ' ') ?></p>
            </div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="mb-5">
        <h4>Revenus mensuels</h4>
        <canvas id="barChart" height="100"></canvas>
    </div>

    <!-- Pie Chart -->
    <div class="mb-5">
        <h4>Utilisateurs actifs vs inactifs</h4>
        <canvas id="pieChart" height="100"></canvas>
    </div>

    <script>
        // Bar Chart (Revenus mensuels)
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Total (DT)',
                    data: <?= json_encode($totaux) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Pie Chart (Utilisateurs actifs vs inactifs)
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Actifs', 'Inactifs'],
                datasets: [{
                    data: [<?= $activeUsers ?>, <?= $inactiveUsers ?>],
                    backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>
