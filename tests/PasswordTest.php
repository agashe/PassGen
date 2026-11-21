<?php

use PassGen\Password;
use PassGen\Random\MTRandom;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * Password Test.
 */
class PasswordTest extends TestCase
{
    /**
     * @var Password $password
     */
    protected Password $password;

    /**
     * Password Test Setup.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->password = new Password();
        $this->password->setRandomGenerator(new MTRandom());

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
        $result = $this->password->create();

        $this->assertEquals('K4nOlN;#-,CS_F}D', $result);
        $this->assertEquals(16, strlen($result));
    }

    /**
     * Test only capital pattern.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testOnlyCapitalPattern(): void
    {
        $result = $this->password->withCapital()->create();

        $this->assertEquals('TJQOTBHPZWONWLZO', $result);
    }

    /**
     * Test only small pattern.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testOnlySmallPattern(): void
    {
        $this->assertEquals(
            'tjqotbhpzwonwlzo',
            $this->password->withSmall()->create()
        );
    }

    /**
     * Test only digits pattern.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testOnlyDigitsPattern(): void
    {
        $this->assertEquals(
            '5948331192896330',
            $this->password->withDigits()->create()
        );
    }

    /**
     * Test only symbols pattern.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testOnlySymbolsPattern(): void
    {
        $this->assertEquals(
            '),*=^+;#-,@]_%}#',
            $this->password->withSymbols()->create()
        );
    }

    /**
     * Test custom pattern.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testCustomPattern(): void
    {
        $this->assertEquals(
            'BCACBBCCCACABCBA',
            $this->password->usePattern('ABC')->create()
        );
    }

    /**
     * Test exclude characters.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testExcludeCharacters(): void
    {
        $this->assertEquals(
            'BBAABBBBBAABABBA',
            $this->password->usePattern('ABC')->exclude(['C'])->create()
        );
    }

    /**
     * Test length.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testLength(): void
    {
        $this->assertEquals(
            'K4nOl',
            $this->password->length(5)->create()
        );
    }

    /**
     * Test large length.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testLargeLength(): void
    {
        $this->assertEquals(
            128,
            strlen($this->password->length(128)->create())
        );
    }

    /**
     * Test an exception will be thrown if password length is less than one.
     *
     * @return void
     */
    #[RunInSeparateProcess]
    public function testExceptionWillBeThrownIfPasswordLengthLessThanOne(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->password->length(-5)->create();
    }
}
