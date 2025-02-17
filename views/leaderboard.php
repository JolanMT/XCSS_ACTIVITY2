<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/styleLeaderboard.css">


</head>

<body>
<?php
echo '
  <nav class="navbar">
  <div class="nav-container">
      <a href="index.php?page=home" class="nav-logo">SCSS Quiz</a>
      <div class="nav-links">';

if (isset($username) && !empty($username)) {
    echo "<div class='user-info'>";
    
    if (isset($profilePicturePath) && !empty($profilePicturePath)) {
        echo "<img src='$profilePicturePath' alt='Profile Picture' class='profile-picture'>";
    } else {
        echo "<img src='public/images/default-profile.png' alt='Default Profile Picture' class='profile-picture'>";
    }

    echo "<span class='welcome-message'>Bonjour, <strong>$username</strong></span>";
    echo '<a href="handlers/logout_handler.php" class="btn-logout">Déconnexion</a>';
    echo '</div>';
} else {
    echo '<a href="index.php?page=login" class="btn-login">Se connecter</a>
    <a href="index.php?page=register" class="btn-register">S\'inscrire</a>';
}

echo '      </div>
  </div>
</nav>
';
?>
    <div class="leaderboard-container">
        <h1>Leaderboard</h1>

        <div class="podium">
            <?php foreach ($topUsers as $rank => $user): ?>
                <div class="podium-column">
                    <div class="podium-rank"><?= ($rank + 1) ?><?= $rank === 0 ? 'ER' : 'EME' ?></div>
                    <img class="profile-pic" src="public/profile_pictures/profile_<?= $user['id'] ?>.png" alt="Photo de profil">
                    <div class="username"><?= htmlspecialchars($user['username']); ?></div>
                    <div class="score"><?= $user['score']; ?> pts</div>
                    <svg width="100" height="<?= $rank === 1 ? 180 : ($rank === 0 ? 120 : 100); ?>" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100%" fill="#ddd" />
                    </svg>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="honorables">
            <h2>Mentions Honorables</h2>
            <?php foreach ($honorableUsers as $user): ?>
                <div class="honorable">
                    <img class="profile-pic" src="public/profile_pictures/profile_<?= $user['id'] ?>.png" alt="Photo de profil">
                    <div>
                        <div class="username"><?= htmlspecialchars($user['username']); ?></div>
                        <div class="score"><?= $user['score']; ?> pts</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>


</html>