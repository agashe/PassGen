<?php

namespace PassGen\Interfaces;

/**
 * Random Interface.
 */
interface RandomInterface
{
    /**
     * Generate a random number.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public function generate(int $min, int $max): int;
}
