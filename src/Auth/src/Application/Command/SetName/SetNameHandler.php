<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetName;

use DegustaBox\Core\Domain\ValueObject\Name;
use DegustaBox\Core\Domain\ValueObject\StringValueObject;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;

readonly class SetNameHandler implements CommandHandler
{
    public function __construct(private SetNameService $service)
    {}

    public function __invoke(SetNameCommand $command): void
    {
        $name = Name::create(
            StringValueObject::create($command->firstName),
            $command->middleName ? StringValueObject::create($command->middleName) : null,
            $command->lastName ? StringValueObject::create($command->lastName) : null
        );

        $this->service->execute(Uuid::create($command->id), $name);
    }
}