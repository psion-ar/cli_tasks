<?php

namespace Psn\CliTasks;

use Carbon\Carbon;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class Command extends SymfonyCommand
{
    protected $database;

    public function __construct(DatabaseAdapter $database)
    {
        $this->database = $database;

        parent::__construct();
    }

    protected function showTasks(SymfonyStyle $io): void
    {
        if (!$tasks = $this->database->fetchAll('tasks')) {
            $io->info('You have no pending tasks right now.');
            return;
        }

        $formatedTasks = $this->formatTasks($tasks);

        $io->title('Your pending tasks:');
        $io->table(['id', 'Created At', 'Task', 'Due Date'], $formatedTasks);
    }

    protected function formatTasks(array $tasks): array
    {
        $formatedTasks = [];

        foreach ($tasks as $task) {
            $formatedTasks[] = [
                'id' => $task['id'],
                'created_at' => Carbon::createFromDate($task['created_at'])->diffForHumans(),
                'task' => strtoupper($task['task']),
                'due_date' => ($task['due_date'])
                ? Carbon::createFromDate($task['due_date'])->diffForHumans()
                : 'there is no due date ...',
            ];
        }

        return $formatedTasks;
    }
}
