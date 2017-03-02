<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 3/2/17
 * Time: 8:05 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\LongUrlRequest;
use App\Libs\UrlHasher;
use App\LongUrl;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ShorterController extends Controller
{
    /**
     * Generate short url link.
     *
     * @param LongUrlRequest|Request $request
     * @return Factory|View
     */
    public function long(LongUrlRequest $request)
    {
        $longUrl  = \App\Libs\nullify($request->get('long_url'));
        $shortUrl = null;

        if ($longUrl !== null) {
            $l           = new LongUrl();
            $l->long_url = $longUrl;
            $l->hash     = UrlHasher::generateHash();
            $l->saveOrFail();

            $shortUrl = route('short_path', ['hash' => $l->hash]);
        }

        if ($request->headers->get('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'url' => $shortUrl,
            ]);
        }

        return view('welcome', [
            'longUrl'  => $longUrl,
            'shortUrl' => $shortUrl,
        ]);
    }

    /**
     * Redirect short url to full long url.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function short(Request $request)
    {
        /** @var LongUrl $longUrl */
        $longUrl = LongUrl::where('hash', UrlHasher::filter($request->path()))->first();

        if ($longUrl === null) {
            return redirect(route('root_path'))->withErrors(['message' => sprintf('Short url %s not found!', $request->url())]);
        }

        return redirect($longUrl->long_url, 302, [
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Expires'       => 'Mon, 01 Jan 1990 00:00:00 GMT',
        ]);
    }
}
