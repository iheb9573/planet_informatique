<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['panier'])) {
    header('Location: pages/login.php');
    exit;
}

$panier = $_SESSION['panier'];
$total = 0;

foreach ($panier as $item) {
    $total += $item['prix'] * $item['quantite'];
}

$pdo->beginTransaction();

$stmt = $pdo->prepare("INSERT INTO commandes (user_id, total) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $total]);
$commande_id = $pdo->lastInsertId();

$stmtItem = $pdo->prepare("INSERT INTO panier (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");

foreach ($panier as $item) {
    $stmtItem->execute([
        $commande_id,
        $item['id'],
        $item['quantite'],
        $item['prix']
    ]);
}

$pdo->commit();
unset($_SESSION['panier']);

header('Location: pages/historique.php');
exit;
?>
