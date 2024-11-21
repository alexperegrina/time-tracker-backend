<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Interfaces\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use DegustaBox\Auth\Domain\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    public function __construct(private readonly JWTTokenManagerInterface $JWTTokenManager) {}

    #[Route('/json', name: 'auth_login_json', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
           'user'  => $user->getUserIdentifier(),
           'token' => $this->JWTTokenManager->create($user),
       ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/jwt', name: 'auth_login_jwt', methods: ['POST'])]
    public function jwt(): void
    {
        // controller can be blank: it will never be called!
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }
}