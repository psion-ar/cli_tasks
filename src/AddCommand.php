<?php

namespace Ar\CliTasks;

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

        return Command::SUCCESS;
    }
}
