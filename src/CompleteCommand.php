<?php

namespace Psn\CliTasks;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CompleteCommand extends Command
{
    public function configure()
    {
        $this->setName('complete')
            ->setDescription('Remove a completed task from the list.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $tasks = $this->database->fetchAll('tasks');
        $formatedTasks = $this->formatTasks($tasks);
        $id = $this->getChoice($io, $formatedTasks);

        $this->database->query('DELETE FROM tasks WHERE id = :id', [
            'id' => $id,
        ]);

        $io->info("Task with id '{$id}' deleted.");

        $this->showTasks($io);

        return Command::SUCCESS;
    }

    private function getChoice(SymfonyStyle $io, array $tasks): string
    {
        $joinedArray = [];
        foreach ($tasks as $task) {
            $joinedArray[$task['id']] = join(' · ', $task);
        }

        $result = $io->choice('What task did you complete?', $joinedArray);

        return substr($result, 0, 1);
    }
}
