<?php
session_start();
require_once '../config/db.php';

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

if ($email && $token) {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ? AND token = ?");
    $stmt->execute([$email, $token]);
    $user = $stmt->fetch();

    if ($user) {
        $update = $pdo->prepare("UPDATE utilisateurs SET actif = 1, token = NULL WHERE email = ?");
        $update->execute([$email]);
        
        $_SESSION['message'] = "✅ Compte activé avec succès ! <a href='../pages/login.php'>Connectez-vous ici</a>";
        header('Location: ../pages/login.php');
        exit;
    } else {
        $_SESSION['message'] = "❌ Lien d'activation invalide ou déjà utilisé.";
        header('Location: ../pages/register.php');
        exit;
    }
} else {
    $_SESSION['message'] = "❌ Paramètres manquants dans le lien d'activation.";
    header('Location: ../pages/register.php');
    exit;
}
?>