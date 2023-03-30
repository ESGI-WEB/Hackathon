<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddContentLikeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    /**
     * @throws \Exception
     */
    public function __invoke(Content $data): Content
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            throw new \Exception('User not found');
        }

        $data->addLike($user);
        $this->entityManager->flush($data);

        return $data;

    }
}
