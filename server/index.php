<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';
require 'handlers.php';

$app = new \Slim\App;

//Routes
/**
 * GET /passagens
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/passagem', function (Request $request, Response $response) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_passagens());

    return $response;
});

/**
 * GET /passagem/{id}
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/passagem/{id}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_passagem($args['id']));

    return $response;
});

$app->post('/passagem/comprar', function (Request $request, Response $response) {

    $params = $request->getParsedBody();
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($params));

    return $response;
});

/**
 * GET /hospedagens
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/hospedagem', function (Request $request, Response $response) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_hospedagens());
    
    return $response;
});

/**
 * GET /hospedagem/{id}
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/hospedagem/{id}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_hospedagem($args['id']));

    return $response;
});

$app->run();
