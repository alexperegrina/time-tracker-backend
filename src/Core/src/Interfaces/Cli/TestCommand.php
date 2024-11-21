<?php
declare(strict_types=1);

namespace DegustaBox\Core\Interfaces\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('test')
            ->setDescription('Comando para testear');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->action();

        $io->success('OK');

        return Command::SUCCESS;
    }

    protected function action(): void
    {

    }
}