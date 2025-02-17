<?php
class ScoreCalculator {
    private $baseScore = 100;

    public function calculateScore($timeTaken) {
        // Deduct points based on time taken
        $penalty = $timeTaken > 0 ? min($timeTaken * 2, $this->baseScore) : 0;
        return max($this->baseScore - $penalty, 0);
    }
}
?>
