<?php
session_start();

if (!isset($_SESSION['message'])) {
    header('Location: panier.php');
    exit;
}

$message = $_SESSION['message'];
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1 class="text-success">Confirmation</h1>
    <p><?= htmlspecialchars($message) ?></p>
    <a href="../index.php" class="btn btn-primary">Retour aux produits</a>
</body>
</html>
