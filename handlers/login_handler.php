<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inclure la connexion à la base de données
    require_once __DIR__ . '/../config/db.php';

    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Vérifier que les champs sont remplis
    if (empty($username) || empty($password)) {
        die("Erreur : Tous les champs sont requis.");
    }

    // Rechercher l'utilisateur dans la base de données
    try {
        $stmt = $pdo->prepare("
            SELECT id, password_hash, profile_picture 
            FROM users 
            WHERE username = :username
        ");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Stocker les informations utilisateur dans la session
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;

            // Vérifier si l'utilisateur a une photo de profil
            if (!empty($user['profile_picture'])) {
                $_SESSION['profile_picture'] = $user['profile_picture'];
            } else {
                $_SESSION['profile_picture'] = null; // Pas d'image de profil
            }

            // Rediriger vers l'accueil
            header("Location: index.php?page=home");
            exit();
        } else {
            echo "Erreur : Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
} else {
    header('Location: ../index.php?page=login');
    exit();
}
