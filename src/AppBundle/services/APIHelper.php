<?php

/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 15:13
 */
namespace AppBundle\services{
    class APIHelper
    {
        private function encodeXML($data, $rootname){
            $xml = new SimpleXMLElement("<".$rootname."/>");
            $tmp = array_flip($data);
            array_walk_recursive($tmp, array($xml, 'addChild'));
            return $xml->asXML();
        }

        function getReturnBody($header, $data, $rootname){
            if (in_array("application/json", $header)){
                return json_encode($data);
            }
            elseif (in_array("application/xml", $header)){
                return APIHelper::encodeXML($data, $rootname);
            }
            else{
                return false;
            }
        }
    }
}