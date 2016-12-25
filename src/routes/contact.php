<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 25/12/2016
 * Time: 20:33
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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