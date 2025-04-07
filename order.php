












?>exit;header('Location: index.php');// Redirect to index.php after login}    exit;    header('Location: login.php');if (!isset($_SESSION['user_id'])) {require_once 'config/db.php';session_start();<?php