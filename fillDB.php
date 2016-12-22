<?php
/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 15:49
 */
use \domain\Art;
use \domain\Category;

require_once "bootstrap.php";

$cats = array(
    new Category("Illustration"),
    new Category("Makeup"),
    new Category("Concept")
);

foreach ($cats as $c){
    $entityManager->persist($c);
}

$user = new \domain\User("irisVC", "iris.verbert@gmail.com","iFMXVbI3KL");
$entityManager->persist($user);

$entityManager->flush();
