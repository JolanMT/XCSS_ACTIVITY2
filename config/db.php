<?php
define('DB_HOST', 'wwor6.h.filess.io');
define('DB_NAME', 'XCSS_sunthereup');
define('DB_USER', 'XCSS_sunthereup');
define('DB_PASSWORD', 'c6ca315dada0ea499eb00b3559fc2ff101884141');
define('DB_PORT', '3305');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, 
        DB_USER, 
        DB_PASSWORD, 
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
