<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\Status;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class CreateContentController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ThemeRepository $themeRepository,
    )
    {}

    public function __invoke(Request $data): Content
    {
        $request = $data->toArray();
        $name = $request['name'] ?? '';
        $requestThemes = $request['themes'] ?? [];
        $description = $request['description'] ?? '';
        $themes = $this->themeRepository->findBy(['id' => $requestThemes]);

        $content = new Content();
        $content->setName($name);

        foreach ($themes as $theme) {
            $content->addTheme($theme);
        }
        $content->setDescription($description);

        $user = $this->getUser();
        if (!$user) {
            throw new AuthenticationException('You must be logged in to create a content');
        }

        $content->setAuthor($user);

        if ($this->isGranted('ROLE_MODERATOR')) {
            $content->setStatus(Status::VALIDATED);
        }
        else {
            $content->setStatus(Status::PENDING);
        }

        $this->entityManager->persist($content);
        $this->entityManager->flush();

        return $content;
    }
}
