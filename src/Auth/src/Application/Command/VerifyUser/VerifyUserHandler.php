<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\VerifyUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;

readonly class VerifyUserHandler implements CommandHandler
{
    public function __construct(private VerifyUserService $service)
    {}

    public function __invoke(VerifyUserCommand $command): void
    {
        $this->service->execute(Uuid::create($command->id));
    }
}