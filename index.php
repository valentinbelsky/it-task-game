<?php
require_once 'vendor/autoload.php';
use App\Controllers\GameController;

try {
    $moves = array_slice($argv, 1);  // Remove the script's filename from the arguments

    if (count($moves) < 3 || count($moves) % 2 === 0) {
        throw new Exception("Error: Please provide an odd number of at least 3 non-repeating moves.");
    }

    $game = new GameController($moves);
    $game->play();

    echo "\nType 'help' for the rules table or any other key to exit: ";
    $input = trim(fgets(STDIN));
    if (strtolower($input) === 'help') {
        $game->showHelp();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

