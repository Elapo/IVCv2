<?php

/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 22/12/2016
 * Time: 22:23
 */
namespace AppBundle\services{
    class SecurityService
    {
        /**CSRF Protection
         * Implementation:
         * - Create hidden form tag using create_token_tag()
         * - verify using token_is_valid()
         */
        private function gen_token()
        {
            return bin2hex(random_bytes(100));
        }

        private function create_token()
        {
            $token = self::gen_token();
            $_SESSION['CSRF_token'] = $token;
            $_SESSION['CSRF_token_time'] = time();
            return $token;
        }

        private function destroy_token()
        {
            $_SESSION['CSRF_token'] = null;
            $_SESSION['CSRF_token_time'] = null;
            return 1;
        }

        function create_token_tag()
        {
            $token = self::create_token();
            return '<input type="hidden" name="form_token" id="token" value="' . $token . '">';
        }

        function token_is_valid()
        {
            if (isset($_POST['form_token'])) {
                $user_token = $_POST['form_token'];
                $stored_token = $_SESSION['CSRF_token'];
                return $user_token === $stored_token;
            } else {
                return false;
            }
        }

        function token_is_recent()
        { //TODO:may need fix
            $max_elapsed = 1800; //30m
            if (isset($_SESSION['CSRF_token_time'])) {
                $stored_time = $_SESSION['CSRF_token_time'];
                if (($max_elapsed + $stored_time) >= time()) {
                    self::destroy_token();
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        /** sessie timeout
         * implementatie:
         * call 1x bij elke request
         */
        function check_session()
        {
            $time=$_SERVER['REQUEST_TIME'];
            $timeout_duration = 1800;
            if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
                session_unset();
                session_destroy();
                session_start();
            }
            $_SESSION['LAST_ACTIVITY'] = $time;
        }

        function check_login($inputPass, $dbPass){
            if(password_verify($inputPass, $dbPass))return true;
            else return false;
        }

        function _hash($input){
            return password_hash($input, PASSWORD_DEFAULT);
        }

        function checkAdmin(){
            if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin']){
                return true;
            }
            else{
                return false;
            }
        }
    }
}