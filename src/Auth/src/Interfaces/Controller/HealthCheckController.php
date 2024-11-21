<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Interfaces\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/ping', name: 'auth_health-check_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return $this->json([
            'message' => 'Ping',
            'path' => 'src/Auth/Controller/HealthCheckController.php',
        ]);
    }
}