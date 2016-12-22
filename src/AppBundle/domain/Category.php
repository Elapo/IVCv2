<?php

/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:37
 */
namespace AppBundle\domain {
    /** @Entity @Table(name="tblCategory") */
    class Category
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        private $id;

        /** @Column(type="string") */
        private $name;

        function __construct($name)
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }
    }
}