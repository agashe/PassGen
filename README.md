# PassGen
PassGen is a PHP library for generating secure, customizable passwords and passphrases. Whether you need a strong random password for an API key, a memorable passphrase for a user account, or just a quick token from the command line — PassGen has you covered with a clean fluent API and a built-in CLI tool.

## Features
- Secure random generation backed by OpenSSL, OS RNG, or Mersenne Twister
- Generate traditional character-based passwords or human-friendly passphrases
- Fluent, chainable API — no configuration files, zero extra dependencies
- Full control over character sets, length, separators, and exclusions
- Pluggable random generator — swap the RNG backend without changing your code
- CLI tool with dedicated commands for passwords and passphrases

## Installation

```
composer require agashe/passgen
```

> **Requirements:** PHP >= 8.0 and the `ext-openssl` extension.

## Password

The `Password` class generates character-based passwords with fine-grained control over what goes in them. You pick which character sets to include — capital letters, small letters, digits, symbols — or supply your own custom pattern. You can also set the length and exclude specific characters you want to avoid (useful for skipping ambiguous characters like `0`, `O`, `I`, or `l`). By default, when no character set is specified, it uses all of them and produces a 16-character password.

```php
<?php

include 'vendor/autoload.php';

use PassGen\Password;

// default: all characters, length 16
echo (new Password())->create();

// only digits, length 6
echo (new Password())->withDigits()->length(6)->create();

// letters only (capital + small), length 20
echo (new Password())->withCapital()->withSmall()->length(20)->create();

// letters + symbols, length 32
echo (new Password())->withCapital()->withSmall()->withSymbols()->length(32)->create();

// custom character pattern
echo (new Password())->usePattern('ABCDEF123456')->length(10)->create();

// exclude ambiguous characters
echo (new Password())->withCapital()->withDigits()->exclude(['0', 'O', 'I', 'l'])->length(16)->create();
```


## Passphrase

The `Passphrase` class generates memorable, human-friendly passphrases by combining random words from a built-in dictionary. Passphrases are easier to remember than random character strings while still being highly secure. You can control the number of words, capitalize them, append digits to each word, change the separator, or exclude specific words you'd rather not appear. Default: 5 words separated by `-`.

```php
<?php

include 'vendor/autoload.php';

use PassGen\Passphrase;

// default: 5 words with "-" separator
echo (new Passphrase())->create();
// e.g. "orbit-bread-motion-canal-spring"

// 4 capitalized words
echo (new Passphrase())->words(4)->capitalize()->create();
// e.g. "River-Cloud-March-Penny"

// custom separator
echo (new Passphrase())->words(3)->setSeparator('_')->create();
// e.g. "ladder_honest_ghost"

// add a random digit after each word
echo (new Passphrase())->words(4)->withNumbers()->create();
// e.g. "orbit3-bread7-motion1-canal5"

// capitalize + numbers + custom separator
echo (new Passphrase())->words(5)->capitalize()->withNumbers()->setSeparator('.')->create();
// e.g. "River4.Cloud2.March9.Penny0.Stone6"

// exclude specific words
echo (new Passphrase())->words(4)->exclude(['death', 'murder', 'evil'])->create();
```

## CLI

The CLI tool ships two sub-commands: **password** and **passphrase**.

```
$ php ./vendor/bin/passgen <command> [options]
```

### password command

```
# default password (all characters, length 16)
$ php ./vendor/bin/passgen password

# 24-character password with capital letters and digits
$ php ./vendor/bin/passgen password --capital --digits --length 24

# small letters and symbols, length 32
$ php ./vendor/bin/passgen password --small --symbols --length 32

# custom pattern
$ php ./vendor/bin/passgen password --pattern "ABCDEF0123" --length 8

# exclude characters (comma-separated list)
$ php ./vendor/bin/passgen password --capital --digits --exclude "0,O,I" --length 20
```

**Available options:**

| Option | Short | Description |
|---|---|---|
| `--capital` | `-c` | Use capital letters |
| `--small` | `-m` | Use small letters |
| `--digits` | `-d` | Use digits |
| `--symbols` | `-y` | Use symbols |
| `--pattern` | `-p` | Provide a custom character pattern |
| `--exclude` | `-e` | Exclude characters (comma-separated) |
| `--length` | `-l` | Password length (default: 16) |

### passphrase command

```
# default passphrase (5 words)
$ php ./vendor/bin/passgen passphrase

# 4 words with capitalization
$ php ./vendor/bin/passgen passphrase --count 4 --capitalize

# custom separator
$ php ./vendor/bin/passgen passphrase --count 3 --separator "_"

# with numbers appended to each word
$ php ./vendor/bin/passgen passphrase --count 4 --numbers

# exclude words (comma-separated list)
$ php ./vendor/bin/passgen passphrase --count 5 --exclude "death,evil"
```

**Available options:**

| Option | Short | Description |
|---|---|---|
| `--capitalize` | `-z` | Capitalize first letter of each word |
| `--separator` | `-p` | Separator between words (default: `-`) |
| `--numbers` | `-n` | Append a random digit to each word |
| `--exclude` | `-e` | Exclude words (comma-separated) |
| `--count` | `-c` | Number of words (default: 5) |

## License
(PassGen) released under the terms of the MIT license.
