<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin']) {
    $_SESSION['message'] = "Accès refusé. Seuls les utilisateurs connectés peuvent passer des commandes.";
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $total = 100; // Example fixed total amount or calculate dynamically

    $stmt = $pdo->prepare("INSERT INTO commandes (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);

    $_SESSION['message'] = "Commande passée avec succès.";
    header('Location: ../index.php');
    exit;
}

// Utilisez un chemin par défaut si la table `images` n'existe pas
$image_path = 'uploads/default.png';

$stmt = $pdo->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY date_commande DESC");
$stmt->execute([$_SESSION['user_id']]);
$commandes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Passer une commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Passer une commande</h1>
    <!-- Affichage de l'image -->
    <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Image utilisateur" style="max-width: 200px; max-height: 200px;">
    <p>Votre commande a été enregistrée avec succès.</p>
    <form method="POST">
        <button type="submit" class="btn btn-success">Passer la commande</button>
    </form>
    <a href="../index.php" class="btn btn-primary mt-3">Retour à l'accueil</a>

    <h2>Mes Commandes</h2>
    <a href="../index.php" class="btn btn-primary mb-3">Retour aux Produits</a>
    <?php if (empty($commandes)): ?>
        <p>Vous n'avez passé aucune commande.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['total'] ?> DT</td>
                    <td><?= $c['date_commande'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
