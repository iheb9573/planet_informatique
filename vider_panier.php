<?php
session_start();
unset($_SESSION['panier']);
header('Location: pages/panier.php');
?>
