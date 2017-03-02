<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 3/2/17
 * Time: 8:05 PM
 */

namespace App\Http\Controllers;

use App\Libs\UrlHasher;
use Illuminate\Http\Request;

class ShorterController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome', [
            'longUrl'  => $request->get('long_url'),
            'shortUrl' => UrlHasher::generateHash(),
        ]);
    }
}
