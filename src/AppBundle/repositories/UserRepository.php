<?php

/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 22/12/2016
 * Time: 22:20
 */
namespace AppBundle\repositories {
    class UserRepository extends \Doctrine\ORM\EntityRepository
    {
        public function getUser()
        {
            return $this->getEntityManager()->find('AppBundle\domain\user', 1);
        }
    }
}