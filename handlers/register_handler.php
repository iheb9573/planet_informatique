<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];
    $motdepasse2 = $_POST['motdepasse2'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $adresse = $_POST['adresse'];

    if ($motdepasse !== $motdepasse2) {
        $_SESSION['message'] = "Les mots de passe ne correspondent pas.";
        header('Location: ../pages/register.php');
        exit;
    }

    // Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT email FROM utilisateurs WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        $_SESSION['message'] = "Cet email est déjà utilisé.";
        header('Location: ../pages/register.php');
        exit;
    }

    $hash = password_hash($motdepasse, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(16));

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, motdepasse, token, is_admin, adresse) VALUES (?, ?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$nom, $email, $hash, $token, $is_admin, $adresse]);

        // Pour le développement local, afficher le lien cliquable
        $lien = "http://localhost/planet-informatique/pages/activation.php?email=".urlencode($email)."&token=$token";
        $_SESSION['activation_link'] = $lien; // Stocker aussi dans la session si besoin
        $_SESSION['message'] = "Compte créé. <a href='$lien' target='_blank'>Cliquez ici pour activer votre compte</a><br><br>"
                              . "Ou copiez ce lien: <input type='text' value='$lien' style='width:100%' onclick='this.select()'>";
        header('Location: ../pages/register.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur : " . $e->getMessage();
        header('Location: ../pages/register.php');
        exit;
    }
}
?>