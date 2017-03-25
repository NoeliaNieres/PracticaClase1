<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/vendor/autoload.php';
require 'usuario.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/usuarios[/]', function (Request $request, Response $response) {
   $datos = Usuario :: TraerTodosLosUsuarios();
   $response->write(json_encode($datos)); 
    
    return $response;
});

$app->run();

