<?php

// Récupérer les réponses de l'utilisateur
$answers = $_SESSION['answers'] ?? [];

// Vérifier qu'il y a bien des réponses enregistrées
if (empty($answers)) {
    die("Aucune réponse enregistrée. Veuillez recommencer le quiz.");
}

// Calculer le score
$totalQuestions = count($answers);
$correctAnswers = count(array_filter($answers, function ($answer) {
    return isset($answer['isCorrect']) && $answer['isCorrect'];
}));

// Récupérer le score total enregistré dans la session
$score = $_SESSION['user_score'] ?? 0;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Final</title>
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
<section class="finalSection">
    <h1>Résultat du Quiz</h1>
    <p>Vous avez répondu correctement à <?= $correctAnswers; ?> sur <?= $totalQuestions; ?> questions.</p>
    <p>Votre score final est : <?= $score; ?> points.</p> <!-- Affichage du score final -->
    <a href="index.php?action=restart" class="btn-restart">Retour à l'accueil</a>
</section>
</body>

</html>