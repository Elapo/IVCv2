<?php
/**
 * Created by PhpStorm.
 * User: Frederik
 * Date: 22/12/2016
 * Time: 22:38
 */

namespace AppBundle\services {
    class MailService
    {
        function send($from, $name, $message, $subject, $token){
            if($this->checkMail($_POST['email']) && $this->checkCaptcha($token)){
                $header='From: webmaster@irisv-c.be'."\r\n".
                    'Reply-To: '.htmlspecialchars($from)."\r\n".
                    'X-Mailer: PHP/'.phpversion();
                $mess=htmlspecialchars("Message from: ".$name."\n\n".$message);
                if(mail('iris.verbert@gmail.com', htmlspecialchars($subject), $mess, $header)){
                    $return['status']=1;
                }
                else{
                    $return['status']=0;
                    $return['message']="Sending email failed, please try again later.";
                }
            }
            else{
                $return['status']=-2;
                $return['message']="Please check your email for mistakes and retake the captcha.";
            }
            return $return;
        }

        private function checkMail($email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $return['email']="validated";
                return true;
            }
            else{
                $return['email']="invalid";
                return false;
            }
        }

        private function checkCaptcha($token){
            $secret_key_captcha="6LfCsScTAAAAAJdc_3W7rv6Myi45jXH18pOf6gvN";
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $resp = $token;
            $ip = $_SERVER['REMOTE_ADDR'];

            $post = [
                'secret' => $secret_key_captcha,
                'response' => $resp,
                'remoteip' => $ip,
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//FIXME: windows host fix, set to true otherwise (?)

            $response = curl_exec($ch);
            curl_close($ch);

            $arr = json_decode($response, true);
            if($arr['success'] == true){
                return true;
            }
            else{
                return false;
            }
        }
    }


}