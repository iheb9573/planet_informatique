<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($motdepasse, $user['motdepasse'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];

        if ($user['is_admin']) {
            header('Location: ../admin/dashboard.php'); // Redirect to admin dashboard
        } else {
            header('Location: ../index.php'); // Redirect to index.php for normal users
        }
        exit;
    } else {
        $_SESSION['message'] = "Email ou mot de passe incorrect.";
        header('Location: ../pages/login.php');
        exit;
    }
}
?>
