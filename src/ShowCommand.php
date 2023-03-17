<?php

namespace Psn\CliTasks;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowCommand extends Command
{
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
}
