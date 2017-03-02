<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 3/2/17
 * Time: 8:10 PM
 */

namespace App\Libs;

class Random
{
    /**
     * Generate random bytes.
     *
     * @param integer $length
     * @return mixed
     */
    public static function bytes($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}
