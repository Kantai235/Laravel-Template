<?php

namespace App\Domains\ShortUrls\Http\Controllers\Frontend;

use App\Domains\ShortUrls\Models\ShortUrls;
use App\Domains\ShortUrls\Services\ShortUrlService;
use App\Http\Controllers\Controller;

/**
 * Class ShortUrlsController.
 */
class ShortUrlsController extends Controller
{
    /**
     * @var ShortUrlService
     */
    protected $service;

    /**
     * ShortUrlsController constructor.
     *
     * @param  ShortUrlService  $service
     */
    public function __construct(ShortUrlService $service)
    {
        $this->service = $service;
    }

    /**
     * @param  ShortUrls  $urls
     * @return \Illuminate\View\View
     */
    public function index(ShortUrls $shortUrls)
    {
        return redirect($shortUrls->url);
    }
}
