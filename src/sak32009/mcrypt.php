<?php

/*
 * @name           mcrypt
 * @namespace      sak32009
 * @description    Create your personal encryption method!
 * @author         Sak32009 <sak32009.com>
 * @copyright      2014+, Sak32009
 * @version        2.0.0
 * @license        MIT
 * @require        PHP >= 5.4
 * @require        PHP EXTENSION MCRYPT
 * @homepage       https://github.com/Sak32009/mcrypt
 */

namespace sak32009;

abstract class mcrypt{

    abstract protected function getAlgo();
    abstract protected function getCipher();
    abstract protected function getMode();
    abstract protected function getIV();
    abstract protected function getOutputType();

    /*
     * Encrypt
     * @param string $salt Salt
     * @param string $str Text
     * @return string
     */
    public function encrypt($salt, $str){

        $iv_size = mcrypt_get_iv_size($this->getCipher(), $this->getMode());
        $create_iv = mcrypt_create_iv($iv_size, $this->getIV());

        $encrypted_salt = $this->encryptSalt($salt, $iv_size);

        $encrypt = mcrypt_encrypt($this->getCipher(), $encrypted_salt, $str, $this->getMode(), $create_iv);

        return $this->outputType($create_iv . $encrypt, 1);

    }

    /*
     * Decrypt
     * @param string $salt Salt
     * @param string $encrypted_string Encrypted string
     * @return string
     */
    public function decrypt($salt, $encrypted_string){

        $iv_size = mcrypt_get_iv_size($this->getCipher(), $this->getMode());

        $encrypted_key = $this->encryptSalt($salt, $iv_size);

        $decoded_string = $this->outputType($encrypted_string);

        $iv_dec = substr($decoded_string, 0, $iv_size);
        $str_dec = substr($decoded_string, $iv_size);

        $decrypt = mcrypt_decrypt($this->getCipher(), $encrypted_key, $str_dec, $this->getMode(), $iv_dec);

        return trim($decrypt, "\0");

    }

    /*
     * Encrypt salt
     * @param string $str Text
     * @param int $size IV size
     * @return string
     */
    protected function encryptSalt($str, $size){

        $hash = hash($this->getAlgo(), $str);

        return substr($hash, 0, $size);

    }

    /*
     * Output type
     * @param string $str Text
     * @param int $type  - 0: hex - 1: base64
     * @return string
     */
    protected function outputType($str, $type = 0){

        if($this->getOutputType() == 0){

            return $type ? bin2hex($str) : hex2bin($str);

        }

        return $type ? base64_encode($str) : base64_decode($str);

    }

}
