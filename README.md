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
In your command line

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
## Examples

## License
(PassGen) released under the terms of the MIT license.
