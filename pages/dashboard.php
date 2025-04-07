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
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
  <span class="navbar-brand">Bienvenue, <?= $_SESSION['nom'] ?> !</span>
  <a href="../logout.php" class="btn btn-danger">Déconnexion</a>
</nav>

<div class="container mt-4">
  <h3>Mon Profil</h3>
  <p>Nom : <?= $_SESSION['nom'] ?></p>
  <p>Email : <?php // tu peux afficher en récupérant de la BDD si besoin ?></p>

  <hr>
  <a href="modifier_profil.php" class="btn btn-warning">Modifier mes informations</a>
</div>

</body>
</html>
