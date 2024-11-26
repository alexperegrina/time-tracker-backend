<?php
declare(strict_types=1);

namespace DegustaBox\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/ping', name: 'app_health-check')]
    public function ping(): JsonResponse
    {
        return $this->json([
            'message' => 'Ping',
            'path' => 'src/App/Controller/HealthCheckController.php',
        ]);
    }
}