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
    <title>Modifier mon profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .edit-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem;
        }
        .btn {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background: #0061f2;
            border: none;
        }
        .btn-primary:hover {
            background: #0056d6;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body class="bg-light">
    <div class="edit-container">
        <h2 class="mb-4">Modifier mon profil</h2>
        
        <form method="POST">
            <div class="mb-4">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="profile.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</body>
</html>
