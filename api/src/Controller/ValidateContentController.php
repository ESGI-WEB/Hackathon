<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidateContentController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {}
    public function __invoke(Content $data): Content
    {
        $data->setStatus(Status::VALIDATED);

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
