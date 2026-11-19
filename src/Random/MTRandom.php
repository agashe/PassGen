<?php

namespace PassGen\Random;

use PassGen\Random\BaseRandom;

/**
 * MT Random Class.
 *
 * This class relies on the PHP implementation of Mersenne Twister algorithm.
 */
class MTRandom extends BaseRandom
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
        return mt_rand($min, $max);
    }
}
