<?php

namespace App\Command;

use App\Controllers\GameController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-table')]
class GenerateTableCommand extends Command
{
    use LockableTrait;

    protected function configure()
    {
        $this->setDescription('Draws a table in the terminal.')->addArgument('array', InputArgument::IS_ARRAY);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::SUCCESS;
        }
        $array = $input->getArgument('array');

        $value = [];
        $n = count($array);
        foreach ($array as $i => $move) {
            $line = [];
            $line[] = $move;
            foreach ($array as $j => $opponent) {
                if ($i === $j) {
                    $line[] = "Draw";
                } elseif (($j - $i + $n) % $n < $n / 2) {
                    $line[] = "Wins";
                } else {
                    $line[] = "Lose";
                }
            }
            $value[] = $line;
        }

        $table = new Table($output);

        array_unshift($array, "v PC/User >");

        $table->setHeaders($array)
            ->setRows($value);
        $table->render();

        $this->release();

        return Command::SUCCESS;
    }
}
