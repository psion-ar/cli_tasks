<?php

namespace Ar\CliTasks;

use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Command extends SymfonyCommand
{
    protected $database;

    public function __construct(DatabaseAdapter $database)
    {
        $this->database = $database;

        parent::__construct();
    }

    public function showTasks($io)
    {
        if (!$tasks = $this->database->fetchAll('tasks')) {
            $io->info('You have no pending tasks right now.');
            return;
        }

        $io->title('Your pending tasks:');
        $io->table(['id', 'Created At', 'Description', 'Due Date'], $tasks);
    }
}
