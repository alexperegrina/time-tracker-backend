<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\DeleteUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;

readonly class DeleteUserHandler implements CommandHandler
{
    public function __construct(private DeleteUserService $service)
    {}

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->service->execute(Uuid::create($command->id));
    }
}