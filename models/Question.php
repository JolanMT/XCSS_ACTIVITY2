<?php
class Question {
    public $text;
    public $options; // Array for multiple choice options, null if text input
    public $correctAnswer;

    public function __construct($text, $options = null, $correctAnswer) {
        $this->text = $text;
        $this->options = $options;
        $this->correctAnswer = $correctAnswer;
    }
}
