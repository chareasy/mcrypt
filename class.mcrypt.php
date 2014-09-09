<?php

	/**************************** GNU General Public License ****************************
	*
	*	http://www.gnu.org/copyleft/gpl.html
	*
	* ************************************* Details *************************************
	*
	*	Project name:			mcrypt
	*	Project url:			https://github.com/Sak32009/mcrypt
	*	Author:					Sak32009 (skype: sak32009)
	*	Description:			Encrypt/Decrypt your data
	*	Programming Language:	PHP5
	*	Version:				0.04final # 09/09/2014
	*
	*	Thanks to: Relyze, xSplit
	*
	* ********************************** Instructions ***********************************
	*
	*	Look at the bottom of the file!
	*
	*************************************************************************************/

abstract class mcrypt{

    abstract protected function getAlgo();
    abstract protected function getCipher();
    abstract protected function getMode();
    abstract protected function getIV();
    abstract protected function getOutputType();

	/* DON'T TOUCH */
	private $key, $iv_size;

	/*************************************************************************************/
	public function __construct($str){

		$this->iv_size = mcrypt_get_iv_size($this->getCipher(), $this->getMode());
		$this->key = $this->key($str);

	}

	private function key($str){

		return substr(hash($this->getAlgo(), $str), 0, $this->iv_size);

	}

	private function output($str, $m = 0){

		return $this->getOutputType() ? ($m ? base64_encode($str) : base64_decode($str)) : ($m ? bin2hex($str) : hex2bin($str));

	}

	public function encrypt($str){

		$iv = mcrypt_create_iv($this->iv_size, $this->getIV());
		$output = mcrypt_encrypt($this->getCipher(), $this->key, $str, $this->getMode(), $iv);

		return $this->output($iv . $output, 1); // iv - encrypt

	}

	public function decrypt($str){

		$str = $this->output($str);
		$iv = substr($str, 0, $this->iv_size);
		$text = substr($str, $this->iv_size);

		$output = mcrypt_decrypt($this->getCipher(), $this->key, $text, $this->getMode(), $iv);

		return strlen($str) < $this->iv_size ? false : rtrim($output, "\0");

	}

}

// EXAMPLE 1
class Rijndael128 extends mcrypt{

	// http://php.net/manual/en/function.hash-algos.php
    protected function getAlgo(){ return 'sha512'; }

	// http://php.net/manual/it/mcrypt.ciphers.php
    protected function getCipher(){ return MCRYPT_RIJNDAEL_128; }

	// http://php.net/manual/en/mcrypt.constants.php
    protected function getMode(){ return MCRYPT_MODE_CBC; }

	/*

		MCRYPT_RAND: system random number generator(windows only)
		MCRYPT_DEV_RANDOM: read data from /dev/random
		MCRYPT_DEV_URANDOM: read data from /dev/urandom

	*/
    protected function getIV(){ return MCRYPT_RAND; }

	/*

		0: hex
		1: base64

	*/
    protected function getOutputType(){ return 0; }

}

$ex1 = new Rijndael128('-----------SALT----------'); // edit salt
$ex1_e = $ex1->encrypt('test Rijndael128');
$ex1_d = $ex1->decrypt($ex1_e);

echo "<b>".$ex1_d."(hex)</b>: ".$ex1_e."<br><br><br>";

// EXAMPLE 2
class Rijndael256 extends mcrypt{

    protected function getAlgo(){ return 'sha512'; }
    protected function getCipher(){ return MCRYPT_RIJNDAEL_256; }
    protected function getMode(){ return MCRYPT_MODE_CBC; }
    protected function getIV(){ return MCRYPT_RAND; }
    protected function getOutputType(){ return 1; }

}

$ex2 = new Rijndael256('-----------SALT----------'); // edit salt
$ex2_e = $ex2->encrypt('test Rijndael256');
$ex2_d = $ex2->decrypt($ex2_e);

echo "<b>".$ex2_d."(base64)</b>: ".$ex2_e;

?>