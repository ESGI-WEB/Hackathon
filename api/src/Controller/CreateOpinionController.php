<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\Opinion;
use App\Entity\Status;
use App\Repository\ContentRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class CreateOpinionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ContentRepository $contentRepository,
    )
    {}

    public function __invoke(Request $data): Opinion
    {
        $request = $data->toArray();
        $text = $request['text'] ?? '';
        $content = $request['content'] ?? [];
        $content = $this->contentRepository->findOneBy(['id' => $content]);

        $opinion = new Opinion();
        $opinion->setContent($content);
        $opinion->setText($text);
        $opinion->setCreatedAt(new \DateTime());

        $user = $this->getUser();
        if (!$user) {
            throw new AuthenticationException('You must be logged in to create a content');
        }

        $opinion->setAuthor($user);

        $this->entityManager->persist($opinion);
        $this->entityManager->flush();

        return $opinion;
    }
}
