<?php

/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:40
 */
namespace AppBundle\domain{
    /** @Entity(repositoryClass="AppBundle\repositories\UserRepository")
     * @Table(name="tblUser") */
    class User implements \JsonSerializable
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        private $id;

        /** @Column(type="string")*/
        private $username;

        /** @Column(type="string")*/
        private $email;

        /** @Column(type="string")*/
        private $password;

        function __construct($username, $email, $password)
        {
            $this->username = $username;
            $this->email = $email;
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }

        function jsonSerialize()
        {
            return array(
                "id" => $this->id,
                "username" => $this->username,
                "email" => $this->email,
                "password" => $this->password
            );
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @param mixed $username
         */
        public function setUsername($username)
        {
            $this->username = $username;
        }

        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }
    }
}