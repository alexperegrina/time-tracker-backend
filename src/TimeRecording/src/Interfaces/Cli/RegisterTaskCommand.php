<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Cli;

use DateTime;
use DegustaBox\Auth\Application\Query\FindUserByEmail\FindUserByEmailQuery;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use DegustaBox\Core\Domain\Messenger\Bus\QueryBus;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Application\Command\CloseTask\CloseTaskCommand;
use DegustaBox\TimeRecording\Application\Command\CreateTask\CreateTaskCommand;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RegisterTaskCommand extends Command
{
    public function __construct(protected CommandBus $commandBus, protected QueryBus $queryBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('time-recording:task:register')
            ->setDescription('Register a task, action=[start, stop]')
            ->addUsage('start task-1 user@degustabox.com')
            ->addUsage('stop task-1 user@degustabox.com')
            ->addArgument('action', InputArgument::REQUIRED, 'What action would you like to register?', null, ['start', 'stop'])
            ->addArgument('name', InputArgument::REQUIRED, 'What name would you like to register?')
            ->addArgument('email', InputArgument::REQUIRED, 'What email would you like to register?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $action = $input->getArgument('action');
        if ($action !== 'start' && $action !== 'stop') {
            $io->error('Invalid action. action=[start, stop]');
            return Command::FAILURE;
        }
        $name = $input->getArgument('name');
        $email = $input->getArgument('email');

        try {
            $user = $this->user($email);
            $this->action($action, $user->id, $name);
        } catch (Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('OK');
        return Command::SUCCESS;
    }

    protected function user(string $email): User
    {
        $query = new FindUserByEmailQuery($email);
        return $this->queryBus->dispatch($query);
    }

    protected function action(string $action, Uuid $userId, string $name): void
    {
        if ($action === 'start') {
            $this->startAction($userId, $name);
        } else {
            $this->stopAction($userId, $name);
        }
    }

    protected function startAction(Uuid $userId, string $name): void
    {
        $now = new DateTime();
        $command = new CreateTaskCommand($userId->value, $name, $now->format(DATE_ATOM));
        $this->commandBus->dispatch($command);
    }

    protected function stopAction(Uuid $userId, string $name): void
    {
        $now = new DateTime();
        $command = new CloseTaskCommand($userId->value, $name, $now->format(DATE_ATOM));
        $this->commandBus->dispatch($command);
    }
}