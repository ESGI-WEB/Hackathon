<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemoveLikeOpinionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {}

    public function __invoke(Opinion $data): Opinion
    {
        /** @var User $user */
        $user = $this->getUser();
        $data->removeLike($user);

        $this->entityManager->flush();

        return $data;
    }

}
