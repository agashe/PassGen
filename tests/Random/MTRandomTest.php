<?php

use PassGen\Random\MTRandom;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * MT Random Test.
 */
class MTRandomTest extends TestCase
{
    /**
     * Test generate random number.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testGenerateRandomNumber(): void
    {
        // force predictable values
        mt_srand(1);

        $this->assertEquals(846, (new MTRandom())->generate(1, 1000));
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

        (new MTRandom())->generate(10, 1);
    }
}
