<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/ping', name: 'time-recording_health-check_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return $this->json([
            'message' => 'Ping',
            'path' => 'src/TimeRecording/Controller/HealthCheckController.php',
        ]);
    }
}