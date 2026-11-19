<?php

namespace PassGen\Random;

use PassGen\Random\BaseRandom;

/**
 * OpenSSL Random Class.
 *
 * This class provides secure random number using OpenSSL Library.
 *
 * Please note: this class requires OpenSSL extension to be installed/enabled.
 */
class OpenSSLRandom extends BaseRandom
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
        if (!extension_loaded('openssl')) {
            throw new \RuntimeException(
                'OpenSSL extension is not installed!'
            );
        }

        $range = $max - $min;

        if ($range === 0) {
            return $min;
        }

        // calculate the largest multiple of ($range + 1) that fits in 32 bits
        $limit = PHP_INT_MAX - (PHP_INT_MAX % ($range + 1));
        $isStrong = false;

        do {
            $bytes = openssl_random_pseudo_bytes(8, $isStrong);

            if (!$isStrong) {
                throw new \RuntimeException(
                    'OpenSSL Random: Weak random bytes generated!'
                );
            }

            // unpack as unsigned 32-bit int and mask to ensure positive value
            // on 32-bit PHP
            $rnd = unpack('N', $bytes)[1] & 0x7FFFFFFF;
        } while ($rnd >= $limit);

        return $min + ($rnd % ($range + 1));
    }
}
