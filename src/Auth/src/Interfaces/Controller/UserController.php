<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Interfaces\Controller;

use DegustaBox\Auth\Application\Command\CreateUser\CreateUserCommand;
use DegustaBox\Auth\Application\Command\SetRoles\SetRolesCommand;
use DegustaBox\Auth\Application\Command\VerifyUser\VerifyUserCommand;
use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use DegustaBox\Core\Domain\Validator\SchemaValidator;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly SchemaValidator $schemaValidator
    ) {}

    #[Route('/registration', name: 'auth_user_registration', methods: ['POST'])]
    public function registration(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $data = $this->schemaValidator->validate(
            $data,
            '@AuthBundle/Resources/schema/Interfaces/Controller/UserController/Request/registration.json'
        );

        $id = Uuid::uuid4();
        $command = new CreateUserCommand($id->value, $data['email'], $data['password']);
        $this->commandBus->dispatch($command);

        $command = new SetRolesCommand($id->value, $data['roles']);
        $this->commandBus->dispatch($command);

        // verificamos el usuario, pero se tendria que hacer en dos pasos
        $command = new VerifyUserCommand($id->value);
        $this->commandBus->dispatch($command);

        return $this->json([]);
    }
}