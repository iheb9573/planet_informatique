<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Planet Informatique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
  <span class="navbar-brand">Admin Dashboard</span>
  <a href="../../logout.php" class="btn btn-danger">Déconnexion</a>
</nav>

<div class="container mt-4">
  <h3>Bienvenue Admin</h3>
  <a href="produits.php" class="btn btn-primary">Gérer les Produits</a>
  <a href="utilisateurs.php" class="btn btn-secondary">Gérer les Utilisateurs</a>
</div>

</body>
</html>
