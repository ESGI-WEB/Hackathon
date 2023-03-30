<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AddLikeOpinionController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {}
    public function __invoke(Opinion $data): Opinion
    {
        /** @var User $user */
        $user = $this->getUser();
        $data->addLike($user);

        $this->entityManager->flush();

        return $data;
    }

}
