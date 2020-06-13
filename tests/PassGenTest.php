<?php

use PHPUnit\Framework\TestCase;
use PassGen as PassGen;

class PassGenTest extends TestCase
{
    public function testValidPassword()
    {
        $password = new PassGen\PassGen(15, 'symbols|numeric');
        
        $this->assertEquals(15, strlen($password->create()));
        $this->assertEquals(10, strlen(PassGen\PassGen::generate()));
        $this->assertEquals(01, strlen(PassGen\PassGen::generate(1)));
        $this->assertEquals(15, strlen(PassGen\PassGen::generate(15, '')));
        $this->assertEquals(25, strlen(PassGen\PassGen::generate(25, 'capital')));
        $this->assertEquals(35, strlen(PassGen\PassGen::generate(35, 'small|capital')));
        $this->assertEquals(50, strlen(PassGen\PassGen::generate(50, 'small|numeric|symbols')));
    }

    public function testPasswordLength()
    {
        $tries = 0;
        $invalidValues = [-10, 0, 100, "100", "test", [], (new \stdClass)];
    
        foreach ($invalidValues as $value) {
            try {
                PassGen\PassGen::generate($value);
            } catch (\Exception $e) {
                $tries += 1;
            }
        }

        $this->assertEquals($tries, count($invalidValues));
    }

    public function testPasswordType()
    {
        $tries = 0;
        $invalidValues = ['blabla', 'small&capital', 123, null, true, [[]], (new \stdClass), 0];
    
        foreach ($invalidValues as $value) {
            try {
                PassGen\PassGen::generate($value);
            } catch (\Exception $e) {
                $tries += 1;
            }
        }

        $this->assertEquals($tries, count($invalidValues));
    }
}