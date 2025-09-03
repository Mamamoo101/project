<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/WebApp/LabWebservice1');

require __DIR__ . '/api/customers.php';
require __DIR__ . '/api/products.php';
require __DIR__ . '/dbconnect.php';

// $app->get('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write("Hello world!");
//     return $response;
// });

// $app->get('/hello/{name}', function (Request $request, Response $response, $args) {
//     $name1 = $args['name'];
//      $response->getBody()->write("Hello GET, $name1");
//      return $response;
//  });

// $app->post('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name1 = $args['name'];
//     $response->getBody()->write("Hello POST, $name1");
//     return $response;
// });

// $app->post('/hello', function (Request $request, Response $response, $args) {
//     $body = $request->getParsedBody();
//     $name1 = $body['name'];
//     $response->getBody()->write("Hello POST Form, $name1");
//     return $response;
// });

$app->run();