<?php

namespace App\Domains\Urls\Services;

use App\Domains\Urls\Models\Url;
use App\Services\BaseService;

/**
 * Class UrlRedirectionService.
 */
class UrlRedirectionService extends BaseService
{
    /**
     * UrlRedirectionService constructor.
     *
     * @param  Url  $url
     */
    public function __construct(Url $url)
    {
        $this->model = $url;
    }
}
