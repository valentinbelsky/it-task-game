<?php

namespace App\Managers;
class RulesManager
{
    private $moves;

    public function __construct($moves) {
        $this->moves = $moves;
    }

    public function determineWinner($playerMove, $computerMove) {
        $numberOfMoves = count($this->moves);
        $playerIndex = array_search($playerMove, $this->moves);
        $computerIndex = array_search($computerMove, $this->moves);
        $winningRange = ($numberOfMoves - 1) / 2;

        if ($playerIndex === $computerIndex) {
            return "Draw";
        } elseif (($playerIndex + $winningRange) >= $numberOfMoves ?
            ($playerIndex - $winningRange <= $computerIndex &&
                $computerIndex < $playerIndex) :
            ($playerIndex < $computerIndex && $computerIndex <= $playerIndex + $winningRange)) {
            return "Computer wins";
        } else {
            return "Player wins";
        }
    }
}