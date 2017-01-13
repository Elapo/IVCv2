<?php

/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:25
 */
namespace AppBundle\domain{
    /** @Entity(repositoryClass="AppBundle\repositories\ArtRepository")
     * @Table(name="tblArt") */
    class Art implements \JsonSerializable
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

        /** @ManyToOne(targetEntity="Category") */
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

        function jsonSerialize()
        {
            return array(
                "id" => $this->id,
                "imageLink" => $this->imageLink,
                "description" => $this->description,
                "date" => $this->date,
                "isVideo" => $this->isVideo,
                "isPromo" => $this->isPromo,
                "category"=> $this->category->getName()
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
        public function isVideo()
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