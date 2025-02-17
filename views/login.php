<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // Vérifiez les identifiants
    $stmt = $db->prepare("SELECT id, password FROM users WHERE pseudo = :pseudo");
    $stmt->execute([':pseudo' => $pseudo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Stocker l'ID utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        echo "Pseudo ou mot de passe incorrect.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
    <form action="index.php?page=loginHandler" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Se connecter</button>
    </form>

</body>

</html>