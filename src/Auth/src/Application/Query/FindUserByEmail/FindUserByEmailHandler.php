<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Query\FindUserByEmail;

use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Exception\UserNotFoundByEmail;
use DegustaBox\Core\Domain\Messenger\Handler\QueryHandler;

readonly class FindUserByEmailHandler implements QueryHandler
{
    public function __construct(private FindUserByEmailService $service) {}

    /**
     * @throws UserNotFoundByEmail
     */
    public function __invoke(FindUserByEmailQuery $command): User
    {
        return $this->service->execute($command->email);
    }
}