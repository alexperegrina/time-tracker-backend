<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\CreateUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;

readonly class CreateUserHandler implements CommandHandler
{
    public function __construct(private CreateUserService $createUserService)
    {}

    public function __invoke(CreateUserCommand $command): void
    {
        $this->createUserService->execute(
            Uuid::create($command->id),
            $command->email,
            $command->password
        );
    }
}