<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetGender;

use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;
use DegustaBox\Core\Domain\ValueObject\Enum\Gender;
use DegustaBox\Core\Domain\ValueObject\Uuid;

readonly class SetGenderHandler implements CommandHandler
{
    public function __construct(private SetGenderService $service)
    {}

    public function __invoke(SetGenderCommand $command): void
    {
        $this->service->execute(Uuid::create($command->id), Gender::fromName($command->gender));
    }
}