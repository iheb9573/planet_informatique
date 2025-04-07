<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prevent admin from deleting their own account
    if ($id == $_SESSION['user_id']) {
        $_SESSION['message'] = "Vous ne pouvez pas supprimer votre propre compte.";
        header('Location: utilisateurs.php');
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: utilisateurs.php');
exit;
?>
