<?php

namespace App\Controller;

use ApiPlatform\Symfony\Validator\Exception\ValidationException;
use App\Entity\Media;
use App\Repository\ContentRepository;
use App\Repository\TypeMediaRepository;
use App\Services\MediaTypeServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Psr7\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;


#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    private MediaTypeServiceInterface $mediaTypeService;
    private ValidatorInterface $validator;
    private ContentRepository $contentRepository;
    private TypeMediaRepository $typeMediaRepository;

    public function __construct(
        MediaTypeServiceInterface $mediaTypeService,
        ValidatorInterface $validator,
        ContentRepository $contentRepository,
        TypeMediaRepository $typeMediaRepository
    ) {
        $this->mediaTypeService = $mediaTypeService;
        $this->validator = $validator;
        $this->contentRepository = $contentRepository;
        $this->typeMediaRepository = $typeMediaRepository;
    }

    public function __invoke(Request $request): Media
    {
        $uploadedFile = $request->files->get('file');

        $mediaObject = new Media();
        $mediaObject->setName(trim($request->request->get('name')));

        $sanitizer = $this->getConfiguredSanitizer();
        $description = trim($request->request->get('description'));
        $description = $sanitizer->sanitize($description);
        $mediaObject->setDescription($description);

        $mediaObject->setContent($this->contentRepository->find($request->request->get('content')));

        if ($uploadedFile) {
            $this->uploadFile($mediaObject, $uploadedFile);
        } else {
            if (!$mediaObject->getDescription()) {
                throw new BadRequestHttpException('You must provide a description or a file');
            }
            $mediaObject->setType($this->typeMediaRepository->findOneBy(['slug' => 'text']));
        }

        return $mediaObject;
    }

    private function uploadFile(Media &$mediaObject, $uploadedFile): void
    {
        if (!$uploadedFile->isValid()) {
            throw new BadRequestHttpException(
                sprintf('File "%s" is not valid', $uploadedFile->getClientOriginalName())
            );
        }

        // max file size is 2 MB
        if ($uploadedFile->getSize() > 2 * 1024 * 1024) {
            throw new BadRequestHttpException(sprintf('File "%s" is too big', $uploadedFile->getClientOriginalName()));
        }

        $extension = $uploadedFile->guessExtension();
        $type = $this->mediaTypeService->getMediaType($extension);
        if (!$type) {
            throw new BadRequestHttpException(
                sprintf('File "%s" has an invalid extension', $uploadedFile->getClientOriginalName())
            );
        }
        $mediaObject->setType($type);
        $mediaObject->setFile($uploadedFile);
    }

    private function getConfiguredSanitizer(): HtmlSanitizer
    {
        $config = (new HtmlSanitizerConfig())
            ->allowSafeElements();
        $config = $config->allowAttribute(
            'style',
            [
                'div',
                'span',
                'p',
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'section',
                'article',
                'ul',
                'ol',
                'li',
                'table',
                'tr',
                'td',
                'th',
                'thead',
                'tbody',
                'tfoot',
                'strong',
                'small',
                'big'
            ]
        );

        return new HtmlSanitizer($config);
    }
}
