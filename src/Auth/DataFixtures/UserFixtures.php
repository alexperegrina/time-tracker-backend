<?php
declare(strict_types=1);

namespace DegustaBox\Auth\DataFixtures;

use DegustaBox\Auth\Application\Command\CreateUser\CreateUserCommand;
use DegustaBox\Auth\Application\Command\SetRoles\SetRolesCommand;
use DegustaBox\Auth\Application\Command\VerifyUser\VerifyUserCommand;
use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly CommandBus $commandBus
    ) {}

    public function load(ObjectManager $manager): void
    {
        $yamlFile = $this->readUsersData();

        foreach ($yamlFile as $user) {
            $command = new CreateUserCommand($user['id'], $user['email'], $user['password']);
            $this->commandBus->dispatch($command);

            $command = new SetRolesCommand($user['id'], $user['roles']);
            $this->commandBus->dispatch($command);

            $command = new VerifyUserCommand($user['id']);
            $this->commandBus->dispatch($command);
        }
    }

    private function readUsersData(): array
    {
        $path = $this->kernel->locateResource('@AuthBundle/Resources/data/users.yaml');
        return Yaml::parseFile($path);
    }
}