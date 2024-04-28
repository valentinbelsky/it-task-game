<?php
namespace App\Controllers;

use App\Managers\CryptoManager;
use App\Managers\RulesManager;

class GameController
{
    private $cryptoManager;
    private $rulesManager;
    private $moves;

    public function __construct($moves) {
        $this->moves = $moves;
        $this->cryptoManager = new CryptoManager();
        $this->rulesManager = new RulesManager($moves);
    }

    public function play() {
        $computerMove = $this->moves[array_rand($this->moves)];
        $hmac = $this->cryptoManager->computeHMAC($computerMove);
        echo "HMAC: $hmac\n";

        foreach ($this->moves as $index => $move) {
            echo ($index + 1) . " - $move\n";
        }
        echo "0 - Exit\n";

        while (true) {
            $choice = readline("Enter your choice: ");
            if ($choice == '0') {
                echo "Exiting game.\n";
                exit;
            } elseif (isset($this->moves[$choice - 1])) {
                $playerMove = $this->moves[$choice - 1];
                $result = $this->rulesManager->determineWinner($playerMove, $computerMove);
                echo "Your move: $playerMove \n";
                echo "Computer's move was: $computerMove\n";
                echo "Result: $result\n";
                echo "Original key: " . $this->cryptoManager->getKey() . "\n";
                break;
            } else {
                echo "Invalid choice, please try again.\n";
            }
        }
    }

    public function showHelp() {

        $moves = implode(" ", $this->moves);

        $output = shell_exec('php bin/console app:generate-table ' . $moves);
        echo $output;

    }
}