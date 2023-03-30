<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemoveContentLikeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function __invoke(Content $data): Content
    {
        /** @var User $user */
        $user = $this->getUser();

        /**
         * @throws \Exception
         */
        if (!$user) {
            throw new \Exception('User not found');
        }

        $data->removeLike($user);
        $this->entityManager->flush($data);

        return $data;

    }
}
