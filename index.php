<?php
/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:49
 */
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;

require "bootstrap.php";

function base_url(){
    $tech = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    return $tech.'://'. $_SERVER['SERVER_NAME'].'/'.'ivc/';
}
//init twig
$twigLoader = new Twig_Loader_Filesystem('src/templates/');
$twig = new Twig_Environment($twigLoader);
$twig->addGlobal('base_url', base_url());

//init services
$securityService = new AppBundle\services\SecurityService();
$securityService->check_session();

$APIHelper = new AppBundle\services\APIHelper();
$mailService = new AppBundle\services\MailService();
/**
 * For future reference: if an error claiming classes are redeclared is thrown, the classes are loaded twice in composer's
 * autoloader. e.g.: I used to load domain, repos and services separately, which isn't required. only AppBundle needs to be
 * loaded.
 */
$artRepo = $entityManager->getRepository('AppBundle\domain\Art');
$userRepo = $entityManager->getRepository('AppBundle\domain\User');
$catRepo = $entityManager->getRepository('AppBundle\domain\Category');

$app = new \Slim\App([
   'settings'=>[
       'displayErrorDetails' => true
   ]
]);

$app->get('/', function (Request $req, Response $resp) use ($twig){
    $twigVar = array(
        "pageTitle" => "Home"
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;
   return $resp->getBody()->write($twig->render('index.html.twig', $twigVar));
});

//include all routes
require 'src/routes/contact.php';
require 'src/routes/gallery.php';
require 'src/routes/admin.php';
require 'src/routes/api.php';

$app->get('/test', function (Request $req, Response $resp) use ($twig, $catRepo){
    return $resp->getBody()->write(base_url());
});


$app->run();