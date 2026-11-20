<?php

namespace PassGen;

use PassGen\Interfaces\PasswordInterface;
use PassGen\Interfaces\RandomInterface;
use PassGen\Random\OSRandom;
use PassGen\Random\OpenSSLRandom;

/**
 * Password Class.
 */
class Password implements PasswordInterface
{
    /**
     * @var array default passwords patterns
     */
    const PASSWORD_PATTERNS = [
        'CAPITAL' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'SMALL'   => 'abcdefghijklmnopqrstuvwxyz',
        'DIGITS'  => '0123456789',
        'SYMBOLS' => '~!@#$%^&*()_-+={[}]|:;"\'<,>.?/`',
    ];

    /**
     * @var int password length
     */
    protected int $length = 16;

    /**
     * @var string password pattern
     */
    protected string $pattern = '';

    /**
     * @var array<string> excludes characters
     */
    protected array $excludes = [];

    /**
     * @var bool use all characters for the password pattern
     */
    protected bool $all = true;

    /**
     * @var RandomInterface $random
     */
    protected RandomInterface $random;

    /**
     * @var Option capital letters pattern
     */
    protected Option $capital;

    /**
     * @var Option small letters pattern
     */
    protected Option $small;

    /**
     * @var Option digits pattern
     */
    protected Option $digits;

    /**
     * @var Option symbols pattern
     */
    protected Option $symbols;

    /**
     * Password Constructor.
     */
    public function __construct()
    {
        $this->capital = new Option();
        $this->small   = new Option();
        $this->digits  = new Option();
        $this->symbols = new Option();
    }

    /**
     * Set random numbers generator.
     *
     * @param RandomInterface $generator
     * @return void
     */
    public function setRandomGenerator(RandomInterface $generator): void
    {
        $this->random = $generator;
    }

    /**
     * Get random number generator.
     *
     * @return RandomInterface
     */
    public function getRandomGenerator(): RandomInterface
    {
        return empty($this->random) ?
            (
                extension_loaded('openssl') ?
                    (new OpenSSLRandom()) :
                    (new OSRandom())
            )
            :
            $this->random;
    }

    /**
     * Enable capital letters.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withCapital(int $min = -1, int $max = -1): object
    {
        $this->capital->enabled = true;
        $this->capital->min = $min;
        $this->capital->max = $max;

        $this->all = false;

        return $this;
    }

    /**
     * Enable small letters.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withSmall(int $min = -1, int $max = -1): object
    {
        $this->small->enabled = true;
        $this->small->min = $min;
        $this->small->max = $max;

        $this->all = false;

        return $this;
    }

    /**
     * Enable digits.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withDigits(int $min = -1, int $max = -1): object
    {
        $this->digits->enabled = true;
        $this->digits->min = $min;
        $this->digits->max = $max;

        $this->all = false;

        return $this;
    }

    /**
     * Enable symbols.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withSymbols(int $min = -1, int $max = -1): object
    {
        $this->symbols->enabled = true;
        $this->symbols->min = $min;
        $this->symbols->max = $max;

        $this->all = false;

        return $this;
    }

    /**
     * Define custom pattern.
     *
     * @param string $pattern
     * @return $this
     */
    public function usePattern(string $pattern): object
    {
        $this->pattern = $pattern;

        $this->all = false;

        return $this;
    }

    /**
     * Exclude characters from the pattern.
     *
     * @param array<string> $chars
     * @return $this
     */
    public function exclude(array $chars): object
    {
        $this->excludes = $chars;

        return $this;
    }

    /**
     * Set password length.
     *
     * @param int $n
     * @return $this
     */
    public function length(int $n): object
    {
        if ($n < 1) {
            throw new \InvalidArgumentException(
                $this::class .
                ': password length can\'t be less than 1'
            );
        }

        $this->length = $n;

        return $this;
    }

    /**
     * Create the password.
     *
     * @return string
     */
    public function create(): string
    {
        // create the pattern
        if ($this->all) {
            $this->pattern = implode('', array_values(self::PASSWORD_PATTERNS));
        } else {
            if ($this->capital->enabled) {
                $this->pattern .= self::PASSWORD_PATTERNS['CAPITAL'];
            }

            if ($this->small->enabled) {
                $this->pattern .= self::PASSWORD_PATTERNS['SMALL'];
            }

            if ($this->digits->enabled) {
                $this->pattern .= self::PASSWORD_PATTERNS['DIGITS'];
            }

            if ($this->symbols->enabled) {
                $this->pattern .= self::PASSWORD_PATTERNS['SYMBOLS'];
            }
        }

        // handle exclusion
        if (!empty($this->excludes)) {
            foreach ($this->excludes as $exclude) {
                $this->pattern = str_replace($exclude, '', $this->pattern);
            }
        }

        $password = '';

        $patternLength = strlen($this->pattern);

        for ($i = 0;$i < $this->length;$i++) {
            $password .= $this->pattern[
                $this->getRandomGenerator()->generate(0, $patternLength - 1)
            ];
        }

        return $password;
    }
}

class Option {
    public function __construct(
        public bool $enabled = false,
        public int $min = -1,
        public int $max = -1
    ) {}
}
