<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Cli;

use DegustaBox\Auth\Application\Query\FindUserByEmail\FindUserByEmailQuery;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use DegustaBox\Core\Domain\Messenger\Bus\QueryBus;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Application\Query\FindTasksByUser\FindTasksByUserQuery;
use DegustaBox\TimeRecording\Domain\Entity\Task;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListTaskCommand extends Command
{
    public function __construct(protected CommandBus $commandBus, protected QueryBus $queryBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('time-recording:task:list')
            ->setDescription('Task list')
            ->addUsage('user@degustabox.com')
            ->addArgument('email', InputArgument::REQUIRED, 'What email would you like to register?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        try {
            $user = $this->user($email);
            $this->list($io, $user->id);
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

    protected function list(SymfonyStyle $io, Uuid $userId): void
    {
        $tasks = $this->tasks($userId);
        $this->printList($io, $tasks);
    }

    /**
     * @return Task[]
     */
    protected function tasks(Uuid $userId): array
    {
        $query = new FindTasksByUserQuery($userId->value);
        return $this->queryBus->dispatch($query);
    }

    protected function printList(SymfonyStyle $io, array $tasks): void
    {
        $io->title('List of tasks');
        foreach ($tasks as $task) {
            $this->printTask($io, $task);
        }
    }

    protected function printTask(SymfonyStyle $io, Task $task): void
    {
        $io->section('Task');
        $io->table(
            ['ID', 'Name', 'User Email', 'Total Time', 'Today Time'],
            [[
                $task->id->value,
                $task->name,
                $task->user()->email(),
                $task->totalTime(),
                $task->todayTime()
            ]]
        );

        $io->section('          Tracking');
        $tracking = [];
        foreach ($task->trackedTasks() as $trackedTask) {
            $tracking[] = [
                '',
                '',
                '',
                $trackedTask->id->value,
                $trackedTask->start->format('d-m-Y H:i:s'),
                $trackedTask->end()?->format('d-m-Y H:i:s'),
                $trackedTask->time(),
                $trackedTask->todayTime()
            ];
        }

        $io->table(
            ['','','','ID', 'Start', 'End', 'Total Time', 'Today Time'],
            $tracking
        );
    }
}