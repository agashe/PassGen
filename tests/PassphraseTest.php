<?php

use PassGen\Passphrase;
use PassGen\Random\MTRandom;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * Passphrase Test.
 */
class PassphraseTest extends TestCase
{
    /**
     * @var Passphrase $passphrase
     */
    protected Passphrase $passphrase;

    /**
     * Passphrase Test Setup.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->passphrase = new Passphrase();
        $this->passphrase->setRandomGenerator(new MTRandom());

        // force predictable random generation
        mt_srand(1);
    }

    /**
     * Test default.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testDefault(): void
    {
        $this->assertEquals(
            'kill-company-build-rocks-full',
            $this->passphrase->create()
        );
    }

    /**
     * Test capitalize.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testCapitalize(): void
    {
        $this->assertEquals(
            'Kill-Company-Build-Rocks-Full',
            $this->passphrase->capitalize()->create()
        );
    }

    /**
     * Test with numbers.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testWithNumbers(): void
    {
        $this->assertEquals(
            'kill9-build8-full3-declare1-hot2',
            $this->passphrase->withNumbers()->create()
        );
    }

    /**
     * Test exclude.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testExclude(): void
    {
        $this->assertEquals(
            'company-build-rocks-full-develop',
            $this->passphrase->exclude(['kill'])->create()
        );
    }

    /**
     * Test number of words.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testNumberOfWords(): void
    {
        $this->assertEquals(
            'kill-company-build-rocks-full-develop-declare-star-hot-field',
            $this->passphrase->words(10)->create()
        );
    }

    /**
     * Test an exception will be thrown if words are less than one.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testExceptionWillBeThrownIfWordsLengthLessThanOne(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->passphrase->words(-5)->create();
    }
}
