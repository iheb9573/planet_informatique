<?php
session_start();
require_once '../../config/db.php';
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM utilisateurs");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Utilisateurs - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h3>Liste des Utilisateurs</h3>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th><th>Nom</th><th>Email</th><th>Actif</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= $u['nom'] ?></td>
          <td><?= $u['email'] ?></td>
          <td><?= $u['actif'] ? '✅' : '❌' ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>
</html>
