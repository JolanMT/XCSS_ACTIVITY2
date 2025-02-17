<?php

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header('Location: index.php?page=home');
    exit();
}




/**
 * Génère un fichier temporaire pour afficher la photo de profil
 */
function saveProfilePicture($base64Image, $userId)
{
    $profileDir = __DIR__ . '/public/profile_pictures/';
    if (!is_dir($profileDir)) {
        mkdir($profileDir, 0755, true);
    }

    $filePath = $profileDir . "profile_$userId.png";
    file_put_contents($filePath, base64_decode($base64Image));
    return "public/profile_pictures/profile_$userId.png";
}





require_once __DIR__ . '/config/db.php';

// Démarrer une session pour suivre les réponses de l'utilisateur
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure les fichiers de contrôleur et de modèle
require_once __DIR__ . '/controllers/QuestionController.php';
require_once __DIR__ . '/models/Question.php';
require_once __DIR__ . '/models/ScoreCalculator.php';
require_once __DIR__ . '/models/UserAnswer.php';

// Charger les questions depuis le fichier JSON
$dataPath = __DIR__ . '/public/data/questions.json';
$questionsData = json_decode(file_get_contents($dataPath), true);

if (!$questionsData || !isset($questionsData['questions'])) {
    die("Erreur : Impossible de charger les questions.");
}


// Créer une instance du contrôleur des questions
$questionController = new QuestionController($questionsData['questions'], $pdo);

// Réinitialiser la session si l'utilisateur commence un nouveau quiz
if (isset($_GET['action']) && $_GET['action'] === 'restart') {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Déterminer la page à afficher
$page = $_GET['page'] ?? 'home';
switch ($page) {
    case 'home':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_SESSION['username'] ?? null;
        $profilePictureBase64 = $_SESSION['profile_picture'] ?? null;
        $profilePicturePath = null;

        if ($profilePictureBase64 && isset($_SESSION['user_id'])) {
            $profilePicturePath = saveProfilePicture($profilePictureBase64, $_SESSION['user_id']);
        }

        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SCSS Quiz</title>
            <link rel="stylesheet" href="public/css/style.css">
        </head>
        <body>
            <nav class="navbar">
                <div class="nav-container">
                    <a href="index.php?page=home" class="nav-logo">SCSS Quiz</a>
                    <div class="nav-links">';
        if ($username) {
            echo "<div class='user-info'>";
            if ($profilePicturePath) {
                echo "<img src='$profilePicturePath' alt='Profile Picture' class='profile-picture'>";
            } else {
                echo "<img src='public/images/default-profile.png' alt='Default Profile Picture' class='profile-picture'>";
            }
            echo "<span class='welcome-message'>Bonjour, <strong>$username</strong></span>";
            echo '<a href="handlers/logout_handler.php" class="btn-logout">Déconnexion</a>
';
            echo '</div>';
        } else {
            echo '<a href="index.php?page=login" class="btn-login">Se connecter</a>
                  <a href="index.php?page=register" class="btn-register">S inscrire</a>';
        }
        echo '      </div>
                </div>
            </nav>
            <section id="StartSection">
                <h1>Bienvenue au Quiz SCSS</h1>
                <p>Testez vos connaissances sur SCSS avec ce quiz interactif.</p>
                <a href="?page=question&number=1" class="btn-start">Commencer le quiz</a>
                <a href="?page=cours" class="btn-cours">Voir le cours</a>
                <a href="?page=leaderboard" class="btn-leaderboard">Voir le leaderboard</a>
            </section>
        </body>
        </html>';
        break;


    case 'cours':
        require_once __DIR__ . '/views/cours.php';
        break;

    case 'question':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }
        $questionNumber = $_GET['number'] ?? 1;
        $questionController->displayQuestion($questionNumber);
        break;


    case 'submitAnswer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userAnswer'])) {
            $userAnswer = $_POST['userAnswer'];
            $currentQuestionNumber = $_GET['number'] ?? 1;
            $questionController->processAnswer($userAnswer, $currentQuestionNumber);
        }
        break;

    case 'finalScore':
        require_once __DIR__ . '/views/finalScore.php';
        break;

    case 'register':
        require_once __DIR__ . '/views/register.php';
        break;

    case 'registerHandler':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/handlers/register_handler.php';
        } else {
            header('Location: index.php?page=register');
        }
        break;

    case 'login':
        require_once __DIR__ . '/views/login.php';
        break;

    case 'loginHandler':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/handlers/login_handler.php';
        } else {
            header('Location: index.php?page=login');
        }
        break;


        case 'leaderboard':
            $users = $questionController->getLeaderboard();
        
            $topUsers = array_slice($users, 0, 3);
            $honorableUsers = array_slice($users, 3, 2);
        
            require_once __DIR__ . '/views/leaderboard.php';
            break;
        

    case 'logout':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?page=home');
        exit();



    default:
        echo '<h1>Erreur 404 : Page non trouvée</h1>';
        break;
}
