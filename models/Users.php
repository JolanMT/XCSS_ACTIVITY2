<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function updateScore($userId, $score) {
        $stmt = $this->db->prepare("UPDATE users SET score = :score WHERE id = :id");
        $stmt->execute([
            ':score' => $score,
            ':id' => $userId
        ]);
    }

    public function getScore($userId) {
        $stmt = $this->db->prepare("SELECT score FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['score'];
    }
}
