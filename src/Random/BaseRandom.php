<?php

namespace PassGen\Random;

use PassGen\Interfaces\RandomInterface;

/**
 * Base Random Class.
 */
abstract class BaseRandom implements RandomInterface
{
    /**
     * Do the random number generation.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    abstract protected function process(int $min, int $max): int;

    /**
     * Generate a random number.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public function generate(int $min, int $max): int
    {
        if ($max < $min) {
            throw new \InvalidArgumentException(
                $this::class .
                ': {$max} must be greater than or equal to {$min}'
            );
        }

        return $this->process($min, $max);
    }
}
