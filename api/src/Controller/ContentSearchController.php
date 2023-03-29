<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ContentSearchController extends AbstractController
{
    public function __construct(private readonly ContentRepository $contentRepository)
    {}

    public function __invoke(Request $request)
    {
        $arrayData = $request->toArray();
        $data = [
            'name' => $arrayData['name'] ?? '',
            'themes' => $arrayData['themes'] ?? [],
            'status' => $arrayData['status'] ?? [],
        ];
        $contents = $this->contentRepository->findBySearchRequest($data);

        return $this->json($contents);
    }
}
