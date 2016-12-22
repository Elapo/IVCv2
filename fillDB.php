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

$art = new Art("Link", "desc", false, false, new Category("Cat"));

$entityManager->persist($art);
$entityManager->flush();
