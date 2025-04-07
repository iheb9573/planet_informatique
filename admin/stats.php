<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

$data = $pdo->query("SELECT DATE_FORMAT(date_commande, '%Y-%m') as mois, SUM(total) as total FROM commandes GROUP BY mois")->fetchAll();
$labels = array_column($data, 'mois');
$totaux = array_column($data, 'total');
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
<a href="dashboard.php" class="btn btn-secondary">Retour au Dashboard</a>
<h2>Revenus mensuels</h2>
<canvas id="chart" width="400" height="150"></canvas>

<script>
const ctx = document.getElementById('chart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Total (DT)',
            data: <?= json_encode($totaux) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
</body>
</html>
