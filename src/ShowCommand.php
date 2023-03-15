<?php

namespace Ar\CliTasks;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowCommand extends Command
{
    private $database;

    public function __construct(DatabaseAdapter $database)
    {
        $this->database = $database;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('show')
            ->setDescription('Show all pending tasks.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->showTasks($io);

        return Command::SUCCESS;
    }

    public function showTasks($io)
    {
        if (!$tasks = $this->database->fetchAll('tasks')) {
            $io->info('You have no pending tasks right now.');
            return;
        }

        $io->title('Your pending tasks:');
        $io->table(['id', 'Created At', 'Description'], $tasks);
    }
}
