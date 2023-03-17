<?php

namespace Psn\CliTasks;

use Carbon\Carbon;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddCommand extends Command
{
    public function configure()
    {
        $this->setName('add')
            ->setDescription('Add a new task.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $task = $this->getTaskDescription($io);
        $dueDate = $this->getDueDate($io);

        $io->listing([
            $task,
            $dueDate ?? 'no due date given',
        ]);

        $this->database->query('INSERT INTO tasks(task, due_date) VALUES(:task, :due_date)', [
            'task' => $task,
            'due_date' => $dueDate,
        ]);

        $this->showTasks($io);

        return Command::SUCCESS;
    }

    private function getTaskDescription(SymfonyStyle $io): string
    {
        $newTask = '';

        do {
            $newTask = $io->ask('Add a new task');
            (!$newTask)
            ? $io->warning('Come on ... at least type something ...')
            : $io->success("Task: {$newTask}");
        } while (!$newTask);

        return $newTask;
    }

    private function getDueDate(SymfonyStyle $io): mixed
    {
        if ($io->confirm('Do you want to add a due date?', false)) {
            $dueDate = $io->choice('When is the task due?', [
                'tomorrow',
                'in two days',
                'in three days',
                'in one week',
            ]);
        }

        $result = match($dueDate ?? 'null') {
            'null' => null,
            'tomorrow' => Carbon::now()->addDay(),
            'in two days' => Carbon::now()->addDays(2),
            'in three days' => Carbon::now()->addDays(3),
            'in one week' => Carbon::now()->addWeek(),
        };

        return $result;
    }
}
