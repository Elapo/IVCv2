<?php

/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:25
 */
namespace domain {
    /** @Entity @Table(name="tblArt") */
    class Art
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        private $id;

        /** @Column(type="string") */
        private $imageLink;

        /** @Column(type="string", length=500) */
        private $description;

        /** @Column(type="datetime", name="upload_date") */
        private $date;

        /** @Column(type="boolean") */
        private $isVideo;

        /** @Column(type="boolean") */
        private $isPromo;

        /** @OneToOne(targetEntity="Category", cascade={"persist"}) */
        private $category;


        function __construct($imageLink, $description, $isVideo, $isPromo, $category)
        {
            $this->imageLink = $imageLink;
            $this->description = $description;
            $this->date = new \DateTime();
            $this->isVideo = $isVideo;
            $this->isPromo = $isPromo;
            $this->category = $category;
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
        public function getImageLink()
        {
            return $this->imageLink;
        }

        /**
         * @param mixed $imageLink
         */
        public function setImageLink($imageLink)
        {
            $this->imageLink = $imageLink;
        }

        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @return mixed
         */
        public function getDate()
        {
            return $this->date;
        }

        /**
         * @param mixed $date
         */
        public function setDate($date)
        {
            $this->date = $date;
        }

        /**
         * @return mixed
         */
        public function getIsVideo()
        {
            return $this->isVideo;
        }

        /**
         * @param mixed $isVideo
         */
        public function setIsVideo($isVideo)
        {
            $this->isVideo = $isVideo;
        }

        /**
         * @return mixed
         */
        public function getIsPromo()
        {
            return $this->isPromo;
        }

        /**
         * @param mixed $isPromo
         */
        public function setIsPromo($isPromo)
        {
            $this->isPromo = $isPromo;
        }

        /**
         * @return mixed
         */
        public function getCategory()
        {
            return $this->category;
        }

        /**
         * @param mixed $category
         */
        public function setCategory($category)
        {
            $this->category = $category;
        }
    }
}