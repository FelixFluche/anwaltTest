<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ImageNotFoundException;
use App\Renderer\HtmlRenderer;
use App\Service\ImageService;
use App\Validator\ImageParamValidator;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImageController
{
    public function __construct(
        private ImageService $imageService,
        private ImageParamValidator $paramValidator
    ) { }

    public function cropImageAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $result = $this->paramValidator->validate($args);

        if ($result->hasErrors()) {
            return new Response();
        }

        try {
            $image = $this->imageService->cropImage($args['fileName'], (int)$args['width'], (int)$args['height']);
        } catch (ImageNotFoundException) {
            return new Response();
        }

        return new Response\RedirectResponse(
            sprintf('http://localhost:8080/images/%s', $image->getFullName())
        );
    }

    public function resizeImageAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $result = $this->paramValidator->validate($args);

        if ($result->hasErrors()) {
            return new Response();
        }

        try {
            $image = $this->imageService->resizeImage($args['fileName'], (int)$args['width'], (int)$args['height']);
        } catch (ImageNotFoundException) {
            return new Response();
        }

        return new Response\RedirectResponse(
            sprintf('http://localhost:8080/images/%s', $image->getFullName())
        );
    }
}
