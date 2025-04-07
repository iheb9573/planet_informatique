<!-- pages/register.php -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Planet Informatique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center">Créer un compte</h2>
  
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
      <?= $_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <form action="../handlers/register_handler.php" method="POST">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom complet</label>
      <input type="text" class="form-control" id="nom" name="nom" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Adresse Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
      <label for="motdepasse" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="motdepasse" name="motdepasse" required>
    </div>

    <div class="mb-3">
      <label for="motdepasse2" class="form-label">Confirmer mot de passe</label>
      <input type="password" class="form-control" id="motdepasse2" name="motdepasse2" required>
    </div>

    <div class="mb-3">
      <label for="adresse" class="form-label">Adresse</label>
      <input type="text" class="form-control" id="adresse" name="adresse" required>
    </div>

    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
      <label class="form-check-label" for="is_admin">Créer un compte administrateur</label>
    </div>

    <button type="submit" class="btn btn-primary">S’inscrire</button>
  </form>

  <p class="mt-3">Déjà un compte ? <a href="login.php">Connexion</a></p>
</div>

</body>
</html>
