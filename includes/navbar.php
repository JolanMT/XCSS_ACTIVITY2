<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si une photo de profil existe dans la session
$username = $_SESSION['username'] ?? null;
$profilePictureBase64 = $_SESSION['profile_picture'] ?? null;
$profilePicturePath = null;

// Générez une image temporaire si une photo est encodée en base64
if ($profilePictureBase64) {
    $profilePicturePath = 'data:image/png;base64,' . $profilePictureBase64;
} else {
    $profilePicturePath = 'public/images/default-profile.png';
}

// Activez le tampon de sortie
ob_start();
?>
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php?page=home" class="nav-logo">SCSS Quiz</a>
        <div class="nav-links">
            <?php if ($username): ?>
                <div class="user-info">
                    <img src="<?= $profilePicturePath ?>" alt="Profile Picture" class="profile-picture">
                    <span class="welcome-message">Bonjour, <strong><?= htmlspecialchars($username) ?></strong></span>
                    <a href="handlers/logout_handler.php" class="btn-logout">Déconnexion</a>
                </div>
            <?php else: ?>
                <a href="index.php?page=login" class="btn-login">Se connecter</a>
                <a href="index.php?page=register" class="btn-register">S inscrire</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php
// Envoyez tout le contenu tamponné
ob_end_flush();
?>
