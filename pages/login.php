<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Planet Informatique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center">Connexion</h2>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-danger">
      <?= $_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <form action="../handlers/login_handler.php" method="POST">
    <div class="mb-3">
      <label for="email" class="form-label">Adresse Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
      <label for="motdepasse" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="motdepasse" name="motdepasse" required>
    </div>

    <button type="submit" class="btn btn-success">Se connecter</button>
  </form>

  <p class="mt-3">Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
</div>
</body>
</html>
