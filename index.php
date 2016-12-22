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

$securityService = new AppBundle\services\SecurityService();
$APIHelper = new AppBundle\services\APIHelper();
$mailService = new AppBundle\services\MailService();

$artRepo = $entityManager->getRepository('AppBundle\domain\Art');
$userRepo = $entityManager->getRepository('AppBundle\domain\User');

$app = new \Slim\App([
   'settings'=>[
       'displayErrorDetails' => true
   ]
]);

$app->get('/', function (req $req, resp $resp) use ($twig){
   return $resp->getBody()->write($twig->render('index.html.twig', array(
       "pageTitle" => "Home"
   )));
});

$app->get('/work', function (req $req, resp $resp) use ($twig){
    return $resp->getBody()->write($twig->render('work.html.twig', array(
        "pageTitle" => "Work",
        "spotlightL" => "",
        "spotlightC" => "",
        "spotlightR" => ""
    )));
});

$app->get('/gallery', function (req $req, resp $resp) use ($twig){
    //todo: get all images
    return $resp->getBody()->write($twig->render('gallery.html.twig', array(
        "pageTitle" => "Gallery"
    )));
});

$app->get('/gallery/{cat}', function (req $req, resp $resp) use ($twig){
    $cat = $req->getAttribute("cat");
    //todo: get all images for cat
    return $resp->getBody()->write($twig->render('gallery.html.twig', array(
        "pageTitle" => "Gallery"
    )));
});

$app->get('/login', function (req $req, resp $resp) use ($twig, $securityService){
    return $resp->getBody()->write($twig->render('admin.html.twig', array(
        "CSRFtoken" => $securityService->create_token_tag()
    )));
});

$app->post('/login', function (req $req, resp $resp){
    //todo:do login
});

$app->get('/contact', function (req $req, resp $resp) use ($twig){
    return $resp->getBody()->write($twig->render('contact.html.twig', array(
        "pageTitle" => "contact",
        "contact" => true
    )));
});
$app->post('/contact', function (req $req, resp $resp) use ($mailService){
    $data = $req->getQueryParams();

    if(!isset($data['name']) || !isset($data['email']) || !isset($data['subject']) || !isset($data['message']) || !isset($data['g-recaptcha-response']))
        return $response = $resp->withStatus(400);

    return $resp->getBody()->write(json_encode($mailService->send($data['email'], $data['name'], $data['message'], $data['subject'], $data['g-recaptcha-response'])));
});

$app->get('/test', function (req $req, resp $resp) use ($userRepo, $artRepo){
    return $resp->getBody()->write(print_r($userRepo->find(1)));
});

$app->run();