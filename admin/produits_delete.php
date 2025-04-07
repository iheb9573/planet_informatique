<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer image avant suppression
    $stmt = $pdo->prepare("SELECT image FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch();

    // Supprimer l'image du dossier uploads
    if ($produit && file_exists('../../' . $produit['image'])) {
        unlink('../../' . $produit['image']);
    }

    // Supprimer le produit
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: produits.php');
exit;
?>
