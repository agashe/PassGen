<?php

use PassGen\Random\OpenSSLRandom;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * OpenSSLRandomRandom Test.
 */
class OpenSSLRandomTest extends TestCase
{
    /**
     * Test generate random number.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testGenerateRandomNumber(): void
    {
        $rand = (new OpenSSLRandom())->generate(1, 1000);

        $this->assertTrue(($rand >= 1) && ($rand <= 1000));
    }

    /**
     * Test an exception will be thrown if min greater than max.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testAnExceptionWillBeThrownIfMinGreaterThanMax(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new OpenSSLRandom())->generate(10, 1);
    }
}
