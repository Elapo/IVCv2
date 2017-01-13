<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 25/12/2016
 * Time: 20:31
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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

$app->get('/gallery', function (Request $req, Response $resp) use ($twig, $artRepo){
    $art = $artRepo->findAll();

    $artInfo = createReducedArtArray($art);

    $descs  = array_map(function($value){
        return $value->getDescription();
    }, $art);
    //required: array of art +  in json format
    $twigVar = array(
        "pageTitle" => "Gallery",
        "art" => $art,
        "imageLinks" => json_encode($artInfo),
        "descriptions" => json_encode($descs)
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;

    return $resp->getBody()->write($twig->render('gallery.html.twig', $twigVar));
});

$app->get('/gallery/{cat}', function (Request $req, Response $resp) use ($twig, $artRepo){
    $cat = $req->getAttribute("cat");

    $art = $artRepo->getArtByCategory($cat);
    $artInfo = createReducedArtArray($art);
    $descs  = array_map(function($value){
        return $value->getDescription();
    }, $art);

    $twigVar = array(
        "pageTitle" => "Gallery",
        "art" => $art,
        "imageLinks" => json_encode($artInfo),
        "descriptions" => json_encode($descs)
    );
    if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'])
        $twigVar['admin'] = true;

    return $resp->getBody()->write($twig->render('gallery.html.twig', $twigVar));
});

function createReducedArtArray($art){
    $artInfo = array();
    $imagelinks  = array_map(function($value){
        return $value->getImageLink();
    }, $art);
    $isVid  = array_map(function($value){
        return $value->isVideo();
    }, $art);
    foreach ($imagelinks as $key=>$link){
        array_push($artInfo, array("link"=> $imagelinks[$key], "isVideo"=>$isVid[$key] ? "1" : "0")); //js expects a string todo:change js so I can dump this abomination
    }

    return $artInfo;
}