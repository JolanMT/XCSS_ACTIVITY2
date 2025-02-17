<?php

class QuestionController
{
    private $questions;
    private $db;

    public function __construct(array $questions, PDO $db)
    {
        $this->questions = $questions;
        $this->db = $db;
    }

    /**
     * Affiche une question en fonction du numéro donné
     */
    public function displayQuestion($questionNumber)
    {
        $questionNumber = (int)$questionNumber;

        if ($questionNumber < 1 || $questionNumber > count($this->questions)) {
            die("Erreur : Question non trouvée.");
        }

        $questionData = $this->questions[$questionNumber - 1];
        $question = (object) [
            'text' => $questionData['question'],
            'options' => $questionData['choices'],
        ];

        require_once __DIR__ . '/../views/question.php';
    }

    /**
     * Traite la réponse de l'utilisateur pour une question
     */
    public function processAnswer($userAnswer, $currentQuestionNumber)
    {
        $currentQuestionNumber = (int)$currentQuestionNumber;
        $currentQuestion = $this->questions[$currentQuestionNumber - 1];
        $isCorrect = ($userAnswer == $currentQuestion['correctAnswer']);

        // Enregistrement de la réponse de l'utilisateur
        $this->storeAnswerInSession($currentQuestionNumber, $currentQuestion, $userAnswer, $isCorrect);

        // Calcul du score de la question et mise à jour du score global de l'utilisateur dans la session
        if ($isCorrect && isset($_SESSION['user_id'])) {
            $this->updateUserScore($_SESSION['user_id'], $currentQuestionNumber);
        }

        // Redirection vers la question suivante ou la page de score final
        if ($currentQuestionNumber >= count($this->questions)) {
            header("Location: index.php?page=finalScore");
        } else {
            header("Location: index.php?page=question&number=" . ($currentQuestionNumber + 1));
        }

        exit();
    }

    /**
     * Calcule le score basé sur le temps écoulé
     */
    public function calculateScore($timeElapsed, $maxTime = 30, $basePoints = 200, $maxPoints = 1000)
    {
        $timeRemaining = max(0, $maxTime - $timeElapsed);
        $timePercentage = $timeRemaining / $maxTime;
        $score = $basePoints + ($timePercentage * ($maxPoints - $basePoints));
        return round($score);
    }

    /**
     * Met à jour le score de l'utilisateur dans la session
     */
    private function updateUserScore($userId, $currentQuestionNumber)
    {
        $timeElapsed = 30 - $_POST['timeElapsed']; // Temps écoulé envoyé depuis le front-end
        $score = $this->calculateScore($timeElapsed);

        // Ajout du score de la question au score global de l'utilisateur
        if (!isset($_SESSION['user_score'])) {
            $_SESSION['user_score'] = 0;
        }
        $_SESSION['user_score'] += $score;

        // Mise à jour du score de l'utilisateur dans la base de données
        $query = "UPDATE users SET score = :score WHERE id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['score' => $_SESSION['user_score'], 'userId' => $userId]);
    }

    /**
     * Enregistre la réponse dans la session
     */
    private function storeAnswerInSession($currentQuestionNumber, $currentQuestion, $userAnswer, $isCorrect)
    {
        if (!isset($_SESSION['answers'])) {
            $_SESSION['answers'] = [];
        }

        $_SESSION['answers'][$currentQuestionNumber] = [
            'question' => $currentQuestion['question'],
            'userAnswer' => $userAnswer,
            'correctAnswer' => $currentQuestion['correctAnswer'],
            'isCorrect' => $isCorrect,
        ];
    }

    /**
     * Récupère les scores pour le leaderboard
     */
    public function getLeaderboard()
    {
        $query = "SELECT id, username, score FROM users ORDER BY score DESC LIMIT 5";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
