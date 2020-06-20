# PassGen
Easy generate powerful passwords for your application

## Features
- Secure passwords , with different compinations
- Easy to use , 0 dependencies
- You can use the generator , to generate any type of random tokens
  (letters , numbers and symbols)
- Select the password length
- You can also use the CLI version to generate your passwords
  not only for your applications

## Installation

``` 
composer require agashe/passgen
```

## Documentation

After installation is done , include the class in your project by:
* including vendor/autoload.php for Native PHP projects
* or adding the class to your framework config , *for example app/config/app.php for laravel* , 

You can choose between use the static method **generate** directly , or 
define a new instance and call the **create** method in your app.

```
<?php

include 'vendor/autoload.php';
use PassGen;

// the static way
echo PassGen\PassGen::generate();

// the instance way
$pass = new PassGen\PassGen();

echo $pass->create();

```

We can use 2 parameters to control both the length and the type of the characters used in for the password

|   Parameter    | Data Type |                Constraints                |
| :------------: | :-------: | ----------------------------------------- | 
| passwordLength |  integer  | password's length between 1 to 50 digits. | 
| passwordType   |   string  | compination of 4 options (capital , small , numeric & symbols) sparated by "\|" or you<br>can leave empty to use all of them!<br>|

and also you can use the CLI version to generate passwords for your accounts.
In your command line:

```
$ php ./vendor/bin/passgen
```
and you can use "-l" to set the length and "-t" to set the type!

## Examples

```
// generate random 3 integers
echo PassGen\PassGen::generate(3, "numeric");

// generate password of 25 letters 
echo PassGen\PassGen::generate(25, "capital|small");

// generate password of small letters and numbers with length 15
echo PassGen\PassGen::generate(15, "numeric|small");

// generate password of letters and symbols with length 50
$myPass = new PassGen\PassGen(50, "symbols|small|capital");

// then call it every where
echo $myPass->create();
// ...
echo $myPass->create();
```

and you can do the same through the CLI
```
$ php ./vendor/bin/passgen -l 15 -t "small|symbols|numeric"
```

## License
(PassGen) released under the terms of the MIT license.
