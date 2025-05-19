<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: produits.php');
    exit;
}

$produit_id = $_GET['id'];

// Vérifier si le produit existe déjà dans le panier
$stmt = $pdo->prepare("SELECT id, quantité FROM panier WHERE user_id = ? AND produit_id = ? AND command_id IS NULL");
$stmt->execute([$_SESSION['user_id'], $produit_id]);
$panier_existant = $stmt->fetch();

if ($panier_existant) {
    // Mettre à jour la quantité si le produit existe déjà
    $stmt = $pdo->prepare("UPDATE panier SET quantité = quantité + 1 WHERE id = ?");
    $stmt->execute([$panier_existant['id']]);
} else {
    // Ajouter un nouveau produit au panier
    $stmt = $pdo->prepare("INSERT INTO panier (user_id, produit_id, quantité) VALUES (?, ?, 1)");
    $stmt->execute([$_SESSION['user_id'], $produit_id]);
}

header('Location: panier.php');
exit;
?>