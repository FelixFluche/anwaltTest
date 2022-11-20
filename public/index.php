<?php declare(strict_types=1);
error_reporting(0);
const TEMPLATE_PATH = '/var/www/html/src/templates/';
const IMAGE_PATH = '/images/';

include '../vendor/autoload.php';

use App\Renderer\HtmlRenderer;
use App\Controller\ImageController;
use App\Service\ImageService;
use App\Validator\ImageParamValidator;
use Intervention\Image\ImageManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

$router->map('GET', '/{fileName}', function (ServerRequestInterface $request, $args): ResponseInterface {
        $controller = new ImageController(
            new ImageService(
                new ImageManager(['driver' => 'imagick'])
            ),
            new HtmlRenderer(TEMPLATE_PATH),
            new ImageParamValidator()
        );
        return $controller->getImageAction($request, $args);
});

$router->map('GET', '/{fileName}/{width}/{height}', function (ServerRequestInterface $request, $args): ResponseInterface {
    $controller = new ImageController(
        new ImageService(
            new ImageManager(['driver' => 'imagick'])
        ),
        new HtmlRenderer(TEMPLATE_PATH),
        new ImageParamValidator()
    );
    return $controller->resizeImageAction($request, $args);
});

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);