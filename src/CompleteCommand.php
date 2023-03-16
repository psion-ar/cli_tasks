<?php

namespace Ar\CliTasks;

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

        return Command::SUCCESS;
    }
}
