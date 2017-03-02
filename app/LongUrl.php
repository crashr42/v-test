<?php

namespace App;

use App\Libs\UrlHasher;

/**
 * @property string long_url
 * @property string hash
 */
class LongUrl extends \Eloquent
{
    const HASH_GENERATE_ITERATIONS = 10;

    protected $fillable = [
        'long_url',
        'hash',
    ];

    /**
     * Generate new hash.
     *
     * @return bool|string
     */
    public static function newHash()
    {
        for ($i = 0; $i < static::HASH_GENERATE_ITERATIONS; ++$i) {
            $hash = UrlHasher::generateHash();

            if (static::where('hash', $hash)->first() === null) {
                return $hash;
            }
        }

        return false;
    }
}
