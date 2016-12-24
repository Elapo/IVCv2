<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 23/12/2016
 * Time: 21:01
 */

namespace AppBundle\controllers;


class UploadController
{
    private $repo;
    private $whitelist = array(".jpg",".jpeg",".gif",".png");//whitelisted file types
    function __construct($ArtRepository)
    {
        $this->repo = $ArtRepository;
    }

    private function checkFileType($data, $info){
        if(($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)){
            return false;
        }
        return $info[2];
    }

    private function createThumbnail($src, $srcName, $info){
        $width = $info[0];
        $height = $info[1];
        $newW = 200;
        $newH = 200;
        //check whether image is landscape or portrait
        if($width > $height){
            $newH = round(($newW/$width)*$height);
        }
        else{
            $newW = round(($newH/$height)*$width);
        }
        $thumb = imagecreatetruecolor($newW, $newH);
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

        imagecopyresampled($thumb, $src, 0,0,0,0,$newW, $newH, $width, $height );
        imagepng($thumb, "/assets/thumb/".$srcName, 3);
    }

    function saveFile($data){
        $info = getimagesize($data['upload']['tmp_name']); //get info about file
        $type = $this->checkFileType($data, $info);
        $return_data = array();

        if(!$type){
            $return_data['status']=0;
            $return_data['errmsg']="Wrong file type";
            return $return_data;
        }
        $ext = pathinfo($data['upload']['name'], PATHINFO_EXTENSION);
        $filename = "art_img_".uniqid().".".$ext;
        $target = "/assets/art/".$filename;
        move_uploaded_file($data,$target);

        switch($type) {
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($_FILES['imupload']['tmp_name']);
                break;
            case IMAGETYPE_JPEG:
                $img = imagecreatefromjpeg($_FILES['imupload']['tmp_name']);
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($_FILES['imupload']['tmp_name']);
                break;
            default:
                $return_data['status']=0;
                $return_data['errmsg']="Invalid image data";
                break;
        }
        if(!isset($img)) return $return_data;
        $this->createThumbnail($img, $filename, $info);

        $return_data['status']=1;
        $return_data['file']=$filename;
        return $return_data;
    }
}