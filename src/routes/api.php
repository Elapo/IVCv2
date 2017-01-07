<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 07/01/2017
 * Time: 22:59
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api', function () use($app, $artRepo){
    $app->get('/art', function (Request $req, Response $resp, $artRepo){

    });
    $app->get('/art/{cat}', function (Request $req, Response $resp, $artRepo){

    });
});