<?php

namespace App;

/**
 * @property string long_url
 * @property string hash
 */
class LongUrl extends \Eloquent
{
    protected $fillable = [
        'long_url',
        'hash',
    ];
}
