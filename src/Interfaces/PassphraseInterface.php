<?php

namespace PassGen\Interfaces;

use PassGen\Interfaces\RandomInterface;

/**
 * Passphrase Interface.
 */
interface PassphraseInterface
{
    /**
     * Set random numbers generator.
     *
     * @param RandomInterface $generator
     * @return void
     */
    public function setRandomGenerator(RandomInterface $generator): void;

    /**
     * Gt random numbers generator.
     *
     * @return RandomInterface
     */
    public function getRandomGenerator(): RandomInterface;

    /**
     * Capitalize words.
     *
     * @return $this
     */
    public function capitalize(): object;

    /**
     * Set words separator.
     *
     * @param string $separator
     * @return $this
     */
    public function setSeparator(string $separator): object;

    /**
     * Add numbers.
     *
     * @return $this
     */
    public function withNumbers(): object;

    /**
     * Exclude specific words.
     *
     * @param array<string> $words
     * @return $this
     */
    public function exclude(array $words): object;

    /**
     * Set number of words.
     *
     * @param int $n
     * @return $this
     */
    public function words(int $n): object;

    /**
     * Create the password.
     *
     * @return string
     */
    public function create(): string;
}
