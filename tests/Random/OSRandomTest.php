<?php

use PassGen\Random\OSRandom;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * OS Random Test.
 */
class OSRandomTest extends TestCase
{
    /**
     * Test generate random number.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testGenerateRandomNumber(): void
    {
        $rand = (new OSRandom())->generate(1, 1000);

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

        (new OSRandom())->generate(10, 1);
    }
}
