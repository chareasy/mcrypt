## mcrypt

[![Latest Stable Version](https://poser.pugx.org/sak32009/mcrypt/v/stable)](https://packagist.org/packages/sak32009/mcrypt)
[![Total Downloads](https://poser.pugx.org/sak32009/mcrypt/downloads)](https://packagist.org/packages/sak32009/mcrypt)
[![Latest Unstable Version](https://poser.pugx.org/sak32009/mcrypt/v/unstable)](https://packagist.org/packages/sak32009/mcrypt)
[![License](https://poser.pugx.org/sak32009/mcrypt/license)](https://packagist.org/packages/sak32009/mcrypt)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/9bc79a65040a4d88bb0dbf85e60437df)](https://www.codacy.com/app/Sak32009/mcrypt)

## Description

Create your personal encryption method!

For the old version thanks to: Relyze, xSplit.

## Requirements

* PHP >= `5.4`
* [MCRYPT](https://secure.php.net/manual/en/book.mcrypt.php)

## Installation

### [Composer](https://getcomposer.org/) (Recommended)

Run the command the following from within your project directory:

```
composer require sak32009/mcrypt
```

```php
include "vendor/autoload.php";
```

### Direct download

If you want to install manually, on the main page you can download or clone the repo.

```php
include "src/sak32009/mcrypt.php";
```

## Usage

Create your own encryption method in this way:

**Note**: This method is the best encryption.

```php
class Rijndael128 extends sak32009\mcrypt{

    // https://secure.php.net/manual/en/function.hash-algos.php
    protected function getAlgo(){ return 'sha256'; }

    // https://secure.php.net/manual/it/mcrypt.ciphers.php
    protected function getCipher(){ return MCRYPT_RIJNDAEL_128; }

    // https://secure.php.net/manual/en/mcrypt.constants.php
    protected function getMode(){ return MCRYPT_MODE_CBC; }

    // https://secure.php.net/manual/en/function.mcrypt-create-iv.php
    // See 'source' parameter.
    protected function getIV(){ return MCRYPT_RAND; }

    /*
     * 0: hex
     * 1: base64
    */
    protected function getOutputType(){ return 0; }

}
```

```php
$aes = new Rijndael128;
```

## Functions

### Encrypt

Use `$aes->encrypt(salt, text)` to encrypt string.

```php
echo $aes->encrypt('my_private_key', 'Sak32009');
```

### Decrypt

Use `$aes->decrypt(salt, encrypted_string)` to encrypt string.

```php
echo $aes->decrypt('my_private_key','0f47ce4c9b6a8cea6cae016f48fcb58080b8dc412bfa91f05d0dc9090518653b');
```

## License

This software is distributed under the [MIT](https://opensource.org/licenses/MIT) license. Please read [LICENSE](LICENSE) for information on the software availability and distribution.

## Changelog

See the [releases pages](https://github.com/Sak32009/mcrypt/releases) for a history of releases and highlights for each release.

## Versioning

Maintained under the Semantic Versioning guidelines as much as possible. Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

For more information, please visit [SEMVER](http://semver.org).

## Author

* Sak32009 `<sak32009.com>`
