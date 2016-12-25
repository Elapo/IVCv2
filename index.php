<?php
/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:49
 */
session_start();
$_SESSION['pleb'] = "ayy";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;

require "bootstrap.php";

//init twig
$twigLoader = new Twig_Loader_Filesystem('src/templates/');
$twig = new Twig_Environment($twigLoader);

$securityService = new AppBundle\services\SecurityService();
$APIHelper = new AppBundle\services\APIHelper();
$mailService = new AppBundle\services\MailService();

/**
 * For future reference: if an error claiming classes are redeclared is thrown, the classes are loaded twice in composer's
 * autoloader. e.g.: I used to load domain, repos and services separately, which isn't required. only AppBundle needs to be
 * loaded.
 */
$artRepo = $entityManager->getRepository('AppBundle\domain\Art');
$userRepo = $entityManager->getRepository('AppBundle\domain\User');

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

$app->get('/work', function (Request $req, Response $resp) use ($twig){
    $twigVar = array(
        "pageTitle" => "Work",
        "spotlightL" => "",
        "spotlightC" => "",
        "spotlightR" => ""
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;

    return $resp->getBody()->write($twig->render('work.html.twig', $twigVar));
});

$app->get('/gallery', function (Request $req, Response $resp) use ($twig){
    //todo: get all images
    $twigVar = array(
        "pageTitle" => "Gallery"
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;

    return $resp->getBody()->write($twig->render('gallery.html.twig', $twigVar));
});

$app->get('/gallery/{cat}', function (Request $req, Response $resp) use ($twig){
    $cat = $req->getAttribute("cat");
    $twigVar = array(
        "pageTitle" => "Gallery"
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;

    //todo: get all images for cat
    return $resp->getBody()->write($twig->render('gallery.html.twig', $twigVar));
});

$app->post('/gallery', function (Request $req, Response $resp) use ($artRepo){
    //todo:do upload
});

$app->get('/login', function (Request $req, Response $resp) use ($twig, $securityService){
    return $resp->getBody()->write($twig->render('admin.html.twig', array(
        "CSRFtoken" => $securityService->create_token_tag() //not actually required for a login form
    )));
});

$app->post('/login', function (Request $req, Response $resp) use ($userRepo){
    $data = $req->getParsedBody();
    if(!isset($data['username']) || !isset($data['password'])) return $response = $resp->withStatus(418);
    $auth = new AppBundle\controllers\AuthenticationController($userRepo);
    return $resp->getBody()->write(json_encode($auth->checkLogin($data['username'], $data['password'])));
});

$app->get('/logout', function (Request $req, Response $resp) use ($twig, $securityService) {
    session_unset();
    session_destroy();
    return $resp->withStatus(302)->withHeader('location', '/Template/');//todo: change for production
});

$app->get('/contact', function (Request $req, Response $resp) use ($twig){
    $twigVar = array(
        "pageTitle" => "Contact",
        "contact" => true
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;

    return $resp->getBody()->write($twig->render('contact.html.twig', $twigVar));
});
$app->post('/contact', function (Request $req, Response $resp) use ($mailService){
    $data = $req->getParsedBody();

    if(!isset($data['name']) || !isset($data['email']) || !isset($data['subject']) || !isset($data['message']) || !isset($data['g-recaptcha-response']))
        return $response = $resp->withStatus(400);

    return $resp->getBody()->write(json_encode($mailService->send($data['email'], $data['name'], $data['message'], $data['subject'], $data['g-recaptcha-response'])));
});

$app->group('/admin', function () use ($app, $twig, $artRepo){
    $app->get('/upload', function(Request $req, Response $resp) use ($twig){
        return $resp->getBody()->write($twig->render('upload.html.twig', array(
            "pageTitle" => "Upload",
            "admin" => true
        )));
    });
    $app->post('/upload', function(Request $req, Response $resp) use ($twig, $artRepo){
        $uploadController = new AppBundle\controllers\UploadController($artRepo);
        $data = $req->getParsedBody();
        return $resp->getBody()->write("hi");
    });
})->add(function(Request $req, Response $resp, $next) use ($securityService){
    if($securityService->checkAdmin()){
        return $resp = $next($req, $resp);
    }
    else{
        return $response = $resp->withStatus(404);
    }
});

$app->run();