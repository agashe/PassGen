<?php

namespace PassGen\Random;

use PassGen\Random\BaseRandom;

/**
 * Operating System Random Class.
 *
 * This class relies on the operating system RNG.
 */
class OSRandom extends BaseRandom
{
    /**
     * Do the random number generation.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    protected function process(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
