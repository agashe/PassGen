<?php

namespace PassGen\Interfaces;

/**
 * Password Interface.
 */
interface PasswordInterface
{
    /**
     * Enable capital letters.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withCapital(int $min, int $max): object;

    /**
     * Enable small letters.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withSmall(int $min, int $max): object;

    /**
     * Enable digits.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withDigits(int $min, int $max): object;

    /**
     * Enable symbols.
     *
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function withSymbols(int $min, int $max): object;

    /**
     * Define custom pattern.
     *
     * @param string $pattern
     * @return $this
     */
    public function usePattern(string $pattern): object;

    /**
     * Exclude characters from the pattern.
     *
     * @param array<string> $chars
     * @return $this
     */
    public function exclude(array $chars): object;

    /**
     * Set password length.
     *
     * @param int $n
     * @return $this
     */
    public function length(int $n): object;

    /**
     * Create the password.
     *
     * @return string
     */
    public function create(): string;
}
