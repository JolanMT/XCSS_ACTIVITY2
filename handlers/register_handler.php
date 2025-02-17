<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inclure la connexion à la base de données
    require_once __DIR__ . '/../config/db.php';

    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $profilePicture = $_FILES['profile_picture'];

    // Vérifier que les champs sont remplis
    if (empty($username) || empty($password)) {
        die("Erreur : Tous les champs sont requis.");
    }

    // Vérifier si un fichier a été uploadé
    $profilePictureData = null;
    if ($profilePicture['error'] === UPLOAD_ERR_OK) {
        // Lire le fichier et compresser l'image si nécessaire
        $imageData = file_get_contents($profilePicture['tmp_name']);
        $profilePictureData = base64_encode($imageData); // Encoder en base64
    }

    // Hash du mot de passe
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insérer dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, profile_picture) VALUES (:username, :password, :profile_picture)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $passwordHash,
            ':profile_picture' => $profilePictureData,
        ]);
        echo "Inscription réussie ! <a href='index.php?page=login'>Connectez-vous ici</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Violation de clé unique (username existant)
            echo "Erreur : Ce nom d'utilisateur est déjà pris.";
        } else {
            die("Erreur : " . $e->getMessage());
        }
    }
} else {
    header('Location: ../index.php?page=register');
    exit();
}
