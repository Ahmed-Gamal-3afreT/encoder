<?php
namespace App\EncryptDecryptClass;
use Auth;
CONST ALG = 'AES-256-CBC';
class EncryptDecrypt
{

    private $userId;
    private $userIdWithSalt;
    private $key;
    private $iv;

    public function __construct()
    {
        $this->userId = Auth::id();
        $this->userIdWithSalt = $this->userId * 5 . "Dev:_Ahmed!@#%Gamal_";
    }
    

    public function encrypt($planText){
       
        $length = rand(10,100);
        $encryption_key = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        $this->key = base64_encode($encryption_key. $this->userIdWithSalt); 
        $ivlen  = openssl_cipher_iv_length(ALG);
        
        $this->iv = openssl_random_pseudo_bytes($ivlen);
        //$this->iv = self::reverseIv($iv);

        $encrypted = openssl_encrypt($planText, ALG, $this->key, $options=0, $this->iv);
        return $encrypted;
    }

    private function reverseIv($iv){
        return $reverce = strrev($iv);
    }

    public function decrypt($cipher, $key, $iv){
        $this->iv = $iv; //self::reverseIv($iv);
      
        $decrepted = openssl_decrypt($cipher, ALG, $key, $options=0, $this->iv);
        return $decrepted;
    }

    public function getKey() {return $this->key;}
    public function getIv() {return $this->iv;}
  
}

