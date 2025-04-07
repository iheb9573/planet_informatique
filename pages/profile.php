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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Planet Informatique</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="historique.php">Historique</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="../logout.php">Déconnexion</a></li>
      </ul>
    </div>
  </div>
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
