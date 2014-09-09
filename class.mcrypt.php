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
	*	Version:				0.03final # 31/08/2014
	*
	* ********************************** Instructions ***********************************
	*
	*	Look at the bottom of the file!
	*
	*************************************************************************************/

class mcrypt{

	/* DON'T TOUCH */
	private $key, $iv_size, $mc;

	/*************************************************************************************/
	public function __construct($str, $mc){

		$this->mc = $mc;

		$this->iv_size = mcrypt_get_iv_size($this->mc->cipher, $this->mc->mode);
		$this->key = $this->key($str);

	}

	private function key($str){

		return substr(hash($this->mc->algo, $str), 0, $this->iv_size);

	}

	private function output($str, $m = 0){

		return $this->mc->ot ? ($m ? base64_encode($str) : base64_decode($str)) : ($m ? bin2hex($str) : hex2bin($str));

	}

	public function encrypt($str){

		$iv = mcrypt_create_iv($this->iv_size, $this->mc->iv);
		$output = mcrypt_encrypt($this->mc->cipher, $this->key, $str, $this->mc->mode, $iv);

		return $this->output($iv . $output, 1); // iv - encrypt

	}

	public function decrypt($str){

		$str = $this->output($str);
		$iv = substr($str, 0, $this->iv_size);
		$text = substr($str, $this->iv_size);

		$output = mcrypt_decrypt($this->mc->cipher, $this->key, $text, $this->mc->mode, $iv);

		return strlen($str) < $this->iv_size ? false : rtrim($output, "\0");

	}

}

// EXAMPLE 1
class example_1_settings{

	public $algo = 'sha512';				// http://php.net/manual/en/function.hash-algos.php
	public $cipher = MCRYPT_RIJNDAEL_128;	// http://php.net/manual/it/mcrypt.ciphers.php
	public $mode = MCRYPT_MODE_CBC;			// http://php.net/manual/en/mcrypt.constants.php
	public $iv = MCRYPT_RAND; /*

		MCRYPT_RAND: system random number generator(windows only)
		MCRYPT_DEV_RANDOM: read data from /dev/random
		MCRYPT_DEV_URANDOM: read data from /dev/urandom

	*/
	public $ot = 0; /*

		0: hex
		1: base64

	*/

}

$example_1_settings = new example_1_settings();
$example_1 = new mcrypt('!!salt!!', $example_1_settings);
$example_1_encrypt = $example_1->encrypt('sak32009');
$example_1_decrypt = $example_1->decrypt($example_1_encrypt);

echo "algo: ".$example_1_settings->algo."<br>
cipher: ".$example_1_settings->cipher."<br>
mode: ".$example_1_settings->mode."<br>
iv: ".$example_1_settings->iv."<br>
ot: ".$example_1_settings->ot."<br>
<b>Example 1 Encrypt:</b> ";
var_dump($example_1_encrypt);
echo "<br><br><b>Example 1 Decrypt:</b> ";
var_dump($example_1_decrypt);

// EXAMPLE 2
echo "<br><br><br>";
class example_2_settings{

	public $algo = 'sha512';
	public $cipher = MCRYPT_RIJNDAEL_256;
	public $mode = MCRYPT_MODE_CBC;
	public $iv = MCRYPT_RAND;
	public $ot = 1;

}

$example_2_settings = new example_2_settings();
$example_2 = new mcrypt('!!salt!!', $example_2_settings);
$example_2_encrypt = $example_2->encrypt('sak32009');
$example_2_decrypt = $example_2->decrypt($example_2_encrypt);

echo "algo: ".$example_2_settings->algo."<br>
cipher: ".$example_2_settings->cipher."<br>
mode: ".$example_2_settings->mode."<br>
iv: ".$example_2_settings->iv."<br>
ot: ".$example_2_settings->ot."<br>
<b>Example 2 Encrypt:</b> ";
var_dump($example_2_encrypt);
echo "<br><br><b>Example 2 Decrypt:</b> ";
var_dump($example_2_decrypt);

?>
