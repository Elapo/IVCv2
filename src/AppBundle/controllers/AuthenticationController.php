<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 24/12/2016
 * Time: 00:25
 */

namespace AppBundle\controllers;


use AppBundle\domain\User;
use AppBundle\repositories\UserRepository;

class AuthenticationController
{
    private $repo;
    function __construct(UserRepository $userRepo)
    {
        $this->repo = $userRepo;
    }

    function checkLogin($userame, $password){
        $dbUser = $this->repo->findBy(array("username" => $userame));
        if(isset($dbUser[0])){ //there will be only 1 user, username is unique
            if(password_verify($password, $dbUser[0]->getPassword())){
                $this->setSession($dbUser[0]);
                $return['status'] = 1;
                return $return;
            }
        }
        $return['status'] = 0;
        $return['errmsg'] = "Wrong username or password";
        return $return;
    }

    private function setSession(User $user){
        $_SESSION['user']['isAdmin'] = true;
        $_SESSION['user']['username'] = $user->getUsername();
        $_SESSION['user']['email'] = $user->getEmail();
    }

}