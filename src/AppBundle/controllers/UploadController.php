<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 23/12/2016
 * Time: 21:01
 */

namespace AppBundle\controllers;


use AppBundle\domain\Art;
use AppBundle\domain\Category;

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
        imagepng($thumb, "assets/thumb/".$srcName, 3);
    }

    function saveFile($data, $desc, Category $cat){
        if(!$data->getError() === UPLOAD_ERR_OK){
            $return_data['status']=0;
            $return_data['errmsg']="file upload failed";
            return $return_data;
        }
        $imageFile = $data->file; //get the file from PSR-7 object
        $info = getimagesize($imageFile); //get info about file
        $type = $this->checkFileType($imageFile, $info);
        $ext = explode("/", $info['mime'])[1];//get the file extension

        //create return data
        $return_data = array();

        if(!$type){ //if the file check failed, file has wrong type
            $return_data['status']=0;
            $return_data['errmsg']="Wrong file type";
            return $return_data;
        }

        //create file name
        $filename = "art_img_".uniqid().".".$ext;
        $target = "assets/art/".$filename;
        move_uploaded_file($imageFile,$target);
        //TODO:refactor this, using exceptions
        //handle null of category

        //get image data to create thumb
        switch($type) {
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($target);
                break;
            case IMAGETYPE_JPEG:
                $img = imagecreatefromjpeg($target);
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($target);
                break;
            default:
                $return_data['status']=0;
                $return_data['errmsg']="Invalid image data";
                break;
        }
        if(!isset($img)) return $return_data; //conversion failed
        $this->createThumbnail($img, $filename, $info);

        if(!isset($cat) || !isset($desc)){
            $return_data['status']=0;
            $return_data['errmsg']="Invalid form data";
            return $return_data;
        }
        $this->repo->save(new Art($filename, htmlspecialchars($desc),0,0,$cat));
        $return_data['status']=1;
        $return_data['file']=$filename;
        return $return_data;
    }
}