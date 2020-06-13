<?php

/**
 * PassGen v1.0.0
 * <https://github.com/agashe/PassGen>
 * 
 * Easy generate powerful passwords for your application.
 * 
 * Author: Mohamed Yousef <engineer.mohamed.yossef@gmail.com>
 * License: MIT
 */

namespace PassGen;

class PassGen
{
    /** CONSTANTS **/
    const MIN_PASSWORD_LENGTH     = 1;
    const MAX_PASSWORD_LENGTH     = 50;
    const DEFAULT_PASSWORD_LENGTH = 10;
    
    const PASSWORD_PATTERNS = [
        'CAPITAL_ALPHABET' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'SMALL_ALPHABET'   => 'abcdefghijklmnopqrstuvwxyz',
        'NUMERIC'          => '0123456789',
        'SYMBOLS'          => '`~!@#$%^&*:;()[]{}<>-+=*_.',
    ];

    const PASSWORD_TYPES = [
        'capital' => 'CAPITAL_ALPHABET',
        'small'   => 'SMALL_ALPHABET',
        'numeric' => 'NUMERIC',
        'symbols' => 'SYMBOLS',
    ];

    const EXCEPTIONS = [
        'length' => 'Invalid password\' length',
        'type'   => 'Invalid password\' type',
    ];
    /** CONSTANTS **/

    /**
     * @var Integer $passwordLength how many digits the password will contain 
     * @var String $passwordType the type of the digits the password includes 
     */
    private $passwordLength;
    private $passwordType;

    public function __construct($passwordLength = self::DEFAULT_PASSWORD_LENGTH, $passwordType = '')
    {
        $this->passwordLength = $passwordLength;
        $this->passwordType = $passwordType;
    }

    /**
     * Generate password for specific length and digits types mix.
     *  
     * @param Integer $passwordLength how many digits the password will contain 
     * @param String $passwordType the type of the digits the password includes 
     * @return String
     */
    public static function generate($passwordLength = self::DEFAULT_PASSWORD_LENGTH, $passwordType = '')
    {
        // validate the length
        if (!is_int($passwordLength) || 
            intval($passwordLength) < self::MIN_PASSWORD_LENGTH || 
            intval($passwordLength) > self::MAX_PASSWORD_LENGTH) {
            throw new \Exception(self::EXCEPTIONS['length']);
        }

        // validate the type then , create the pattern if valid!
        $pattern = '';
        if (is_string($passwordType) && !is_array($passwordType)) {
            if (!empty($passwordType)) {
                $selectedTypes = array_unique(explode('|', trim($passwordType, '|')));
                foreach ($selectedTypes as $type) {
                    if (!array_key_exists($type, self::PASSWORD_TYPES)) {
                        throw new \Exception(self::EXCEPTIONS['type']);
                    } else {
                        $pattern .= self::PASSWORD_PATTERNS[self::PASSWORD_TYPES[$type]];
                    }
                }
            } else {
                $pattern = implode(self::PASSWORD_PATTERNS);
            } 
        } else {
            throw new \Exception(self::EXCEPTIONS['type']);
        }
        
        // create the password
        $password = '';
        $patternLength = strlen($pattern);
        for ($i = 0;$i < $passwordLength;$i++) {
            $password .= $pattern[mt_rand(0, $patternLength-1)];
        }

        return $password;
    }

    /**
     * Create new password.
     *  
     * @return String
     */
    public function create()
    {
        return self::generate($this->passwordLength, $this->passwordType);
    }
}

?>