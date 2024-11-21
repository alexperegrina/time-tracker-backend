<?php
declare(strict_types=1);

namespace DegustaBox\Core\Interfaces\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/ping', name: 'core_health-check_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return $this->json([
            'message' => 'Ping',
            'path' => 'src/Core/Controller/HealthCheckController.php',
        ]);
    }
}