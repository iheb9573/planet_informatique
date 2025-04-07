<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $stmt = $pdo->prepare("UPDATE utilisateurs SET nom = ? WHERE id = ?");
    $stmt->execute([$nom, $id]);
    $_SESSION['nom'] = $nom;
    $_SESSION['message'] = "Profil mis à jour.";
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Modifier mes informations</h2>

  <form method="POST">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" class="form-control" name="nom" value="<?= $user['nom'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
  </form>
</div>
</body>
</html>
