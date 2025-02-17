<?php
class UserAnswer {
    public $questionId;
    public $userResponse;
    public $timeTaken;

    public function __construct($questionId, $userResponse, $timeTaken) {
        $this->questionId = $questionId;
        $this->userResponse = $userResponse;
        $this->timeTaken = $timeTaken;
    }
}
?>
