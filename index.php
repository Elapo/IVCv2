<?php
/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:49
 */
use \Psr\Http\Message\ServerRequestInterface as req;
use \Psr\Http\Message\ResponseInterface as resp;
use \Respect\Validation\Validator as v;

require "bootstrap.php";

//init twig
$twigLoader = new Twig_Loader_Filesystem('src/templates/');
$twig = new Twig_Environment($twigLoader);

$app = new \Slim\App([
   'settings'=>[
       'displayErrorDetails' => true
   ]
]);

$app->get('/', function (req $req, resp $resp) use ($twig){
   return $resp->getBody()->write($twig->render('index.html', array(
       "pageTitle" => "Title",
       "content" => "hey"
   )));
});

$app->run();