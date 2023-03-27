<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    #[Route('/ping', name: 'app_ping', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([
            'message' => 'pong',
        ]);
    }
}
