<?php
session_start();
require_once '../config/db.php';


if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    $_SESSION['message'] = "Accès refusé. Cette page est réservée aux administrateurs.";
    header('Location: ../pages/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $description, $prix]);

    $_SESSION['message'] = "Produit ajouté avec succès.";
    header('Location: manage-product.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gérer les Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h2>Ajouter un Produit</h2>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
        <?= $_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom du Produit</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="mb-3">
        <label for="prix" class="form-label">Prix (DT)</label>
        <input type="number" class="form-control" id="prix" name="prix" required>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>
</body>
</html>
