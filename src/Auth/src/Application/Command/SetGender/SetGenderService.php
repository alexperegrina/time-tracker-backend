<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetGender;

use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Enum\Gender;
use DegustaBox\Core\Domain\ValueObject\Uuid;

readonly class SetGenderService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, Gender $gender): void
    {
        $user = $this->userRepository->findById($id);

        $user->setGender($gender);

        $this->userRepository->save($user);
    }
}