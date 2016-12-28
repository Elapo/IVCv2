<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 25/12/2016
 * Time: 20:29
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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

$app->group('/admin', function () use ($app, $twig, $artRepo, $catRepo){//todo: fix linking assets
    $app->get('/upload', function(Request $req, Response $resp) use ($twig, $catRepo){
        return $resp->getBody()->write($twig->render('upload.html.twig', array(
            "pageTitle" => "Upload",
            "admin" => true,
            "categories" => $catRepo->findAll()
        )));
    });
    $app->post('/upload', function(Request $req, Response $resp) use ($twig, $artRepo){
        $uploadController = new AppBundle\controllers\UploadController($artRepo);
        $file = $req->getUploadedFiles(); //returns slim-specific thingy
        //possibly just use $_FILE
        $data = $req->getParsedBody();
//        $uploadController->saveFile();
        return $resp->getBody()->write(print_r($file));
    });
})->add(function(Request $req, Response $resp, $next) use ($securityService){
    if($securityService->checkAdmin()){
        return $resp = $next($req, $resp);
    }
    else{
        throw new \Slim\Exception\NotFoundException($req, $resp);
    }
});