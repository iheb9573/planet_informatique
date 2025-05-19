<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Mettre à jour la session avec le nom d'utilisateur
if ($user && isset($user['nom'])) {
    $_SESSION['nom'] = $user['nom'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #0061f2;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 1rem;
        }
        .info-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        .btn-edit {
            background: #0061f2;
            color: white;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
        }
        .btn-edit:hover {
            background: #0056d6;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h2><?= htmlspecialchars($user['nom'] ?? 'Utilisateur') ?></h2>
            <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
        </div>

        <div class="info-card">
            <h4>Informations personnelles</h4>
            <hr>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nom :</strong>
                </div>
                <div class="col-md-8">
                    <?= htmlspecialchars($user['nom'] ?? 'Non défini') ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Email :</strong>
                </div>
                <div class="col-md-8">
                    <?= htmlspecialchars($user['email']) ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Date d'inscription :</strong>
                </div>
                <div class="col-md-8">
                    <?= date('d/m/Y', strtotime($user['date_creation'])) ?>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="modifier_profil.php" class="btn btn-edit">
                <i class="fas fa-edit me-2"></i>Modifier mon profil
            </a>
            <a href="../index.php" class="btn btn-secondary mt-2">
                <i class="fas fa-home me-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
