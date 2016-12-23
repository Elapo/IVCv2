<?php

/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 16:51
 */
namespace AppBundle\repositories {
    class ArtRepository extends \Doctrine\ORM\EntityRepository
    {
        function save($art)
        {
            $this->getEntityManager()->merge($art);
        }

        function delete($id)
        {
            $this->getEntityManager()->remove(
                $this->getEntityManager()->getReference('\domain\Art', $id)
            );
        }

        function getArtById($id)
        {
            return $this->_em->find('AppBundle\domain\Art', $id);
        }

        function getArtByCategory($cat)
        {
            $query = $this->getEntityManager()->createQuery('SELECT a FROM domain\Art a WHERE a.category = ?1');
            $query->setParameter(1, $cat);
            return $query->getResult();
        }
    }
}