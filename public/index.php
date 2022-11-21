<?php declare(strict_types=1);
error_reporting(0);

include '../vendor/autoload.php';

use App\Controller\ImageController;
use App\Service\ImageService;
use App\Validator\ImageParamValidator;
use Intervention\Image\ImageManager;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;
$controller = new ImageController(
    new ImageService(
        new ImageManager(['driver' => 'imagick'])
    ),
    new ImageParamValidator()
);

$router->map('GET', '/{fileName}/crop/{width}/{height}', $controller->cropImageAction(...));
$router->map('GET', '/{fileName}/resize/{width}/{height}', $controller->resizeImageAction(...));
$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);