<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 3/2/17
 * Time: 8:05 PM
 */

namespace App\Http\Controllers;

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
     * @param Request $request
     * @return Factory|View
     */
    public function long(Request $request)
    {
        $longUrl  = \App\Libs\nullify($request->input('long_url'));
        if (!UrlHasher::urlIsValid($longUrl)) {
            $urlInvalidMsg = 'Url invalid.';

            if ($request->isXmlHttpRequest()) {
                return response()->json(['error' => $urlInvalidMsg])->setStatusCode(422);
            } else {
                return view('welcome', compact('longUrl', 'shortUrl'))->withErrors(['message' => $urlInvalidMsg]);
            }
        }

        $shortUrl = null;

        if ($longUrl === null) {
            return view('welcome', compact('longUrl', 'shortUrl'));
        }

        $hash = LongUrl::newHash();
        if ($hash === false) {
            $hashCollisionMsg = "Can't generate url. Try again later.";

            if ($request->isXmlHttpRequest()) {
                return response()->json(['error' => $hashCollisionMsg])->setStatusCode(422);
            } else {
                return view('welcome', compact('longUrl', 'shortUrl'))->withErrors(['message' => $hashCollisionMsg]);
            }
        }

        $l           = new LongUrl();
        $l->long_url = $longUrl;
        $l->hash     = $hash;
        $l->saveOrFail();

        $shortUrl = route('short_path', ['hash' => $l->hash]);

        if ($request->isXmlHttpRequest()) {
            return response()->json([
                'url' => $shortUrl,
            ]);
        }

        return view('welcome', compact('longUrl', 'shortUrl'));
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
