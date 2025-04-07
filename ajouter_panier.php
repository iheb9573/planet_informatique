<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: pages/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: pages/produits.php');
    exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    header('Location: pages/produits.php');
    exit;
}

// Vérifier si le produit est déjà dans le panier pour cet utilisateur
$stmt = $pdo->prepare("SELECT * FROM panier WHERE user_id = ? AND produit_id = ? AND command_id IS NULL");
$stmt->execute([$_SESSION['user_id'], $id]);
$panierItem = $stmt->fetch();

if ($panierItem) {
    // Si le produit est déjà dans le panier, augmenter la quantité
    $stmt = $pdo->prepare("UPDATE panier SET quantité = quantité + 1 WHERE id = ?");
    $stmt->execute([$panierItem['id']]);
} else {
    // Sinon, insérer un nouveau produit dans le panier
    $stmt = $pdo->prepare("INSERT INTO panier (user_id, produit_id, quantité) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $id, 1]);
}

header('Location: pages/panier.php');
exit;
?>
