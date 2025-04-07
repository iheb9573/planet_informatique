<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY date_commande DESC");
$stmt->execute([$_SESSION['user_id']]);
$commandes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Planet Informatique</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="../logout.php">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<h2>Historique de Commandes</h2>

<?php if (!$commandes): ?>
    <p>Aucune commande trouvée.</p>
<?php else: ?>
    <table class="table">
        <thead><tr><th>ID</th><th>Total</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($commandes as $c): ?>
            <tr>
                <td>#<?= $c['id'] ?></td>
                <td><?= $c['total'] ?> DT</td>
                <td><?= $c['date_commande'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
