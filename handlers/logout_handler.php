<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Supprimer le fichier temporaire de la photo de profil
if (isset($_SESSION['user_id'])) {
    $profilePicturePath = __DIR__ . '/../public/profile_pictures/profile_' . $_SESSION['user_id'] . '.png';
    if (file_exists($profilePicturePath)) {
        unlink($profilePicturePath);
    }
}

// Détruire la session
session_unset();
session_destroy();

// Rediriger vers la page d'accueil
header("Location: ../index.php?page=home");
exit();
