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
        private HtmlRenderer $htmlRenderer,
        private ImageParamValidator $paramValidator
    ) { }

    public function getImageAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        try {
            $image = $this->imageService->getImage($args['fileName']);
        } catch (ImageNotFoundException $exception) {
            return $this->buildErrorResponse($exception->getMessage());
        } catch (\Exception $exception) {
            return $this->buildErrorResponse('Something went wrong. Please try again');
        }

        $html = $this->htmlRenderer->render(
            'index.html',
            [
                'image' =>  IMAGE_PATH . $image->getFullName()
            ]
        );

        return new Response\HtmlResponse(
            $html
        );
    }

    public function resizeImageAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $result = $this->paramValidator->validate($args);

        if ($result->hasErrors()) {
            return $this->buildErrorResponse(implode(',', $result->getErrors()));
        }

        try {
            $image = $this->imageService->resizeImage($args['fileName'], (int)$args['width'], (int)$args['height']);
        } catch (ImageNotFoundException $exception) {
            return $this->buildErrorResponse($exception->getMessage());
        } catch (\Exception $exception) {
            return $this->buildErrorResponse('Something went wrong. Please try again');
        }

        return new Response\RedirectResponse(
            sprintf('/%s', $image->getFullName())
        );
    }

    private function buildErrorResponse(string $message): ResponseInterface
    {
        $html = $this->htmlRenderer->render(
            'error.html',
            [
                'error' => $message
            ]
        );

        return new Response\HtmlResponse(
            $html
        );
    }
}
