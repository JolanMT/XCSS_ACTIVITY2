<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="public/css/style.css">

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
    <form action="index.php?page=registerHandler" method="POST" enctype="multipart/form-data">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <label for="profile_picture">Photo de profil :</label>
        <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

        <button type="submit">S'inscrire</button>
    </form>
</body>

</html>