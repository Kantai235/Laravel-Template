<?php

namespace App\Domains\ShortUrls\Services;

use App\Domains\ShortUrls\Models\ShortUrls;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class ShortUrlService.
 */
class ShortUrlService extends BaseService
{
    /**
     * ShortUrlService constructor.
     *
     * @param  ShortUrls  $urls
     */
    public function __construct(ShortUrls $urls)
    {
        $this->model = $urls;
    }

    /**
     * @param  array  $data
     * @return ShortUrls
     *
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): ShortUrls
    {
        DB::beginTransaction();

        try {
            if (!isset($data['keyword'])) {
                do {
                    $keyword = Str::random(8);
                } while (ShortUrls::where('keyword', $keyword)->exists());
            } else {
                $keyword = $data['keyword'];
            }

            $original = $data;
            $original['keyword'] = $keyword;

            $urls = $this->createShortUrls($original);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this short urls. Please try again.'));
        }

        // event(new ShortUrlsCreated($urls));

        DB::commit();

        return $urls;
    }

    /**
     * @param  ShortUrls  $urls
     * @param  array  $data
     * @return ShortUrls
     *
     * @throws \Throwable
     */
    public function update(ShortUrls $urls, array $data = []): ShortUrls
    {
        DB::beginTransaction();

        try {
            $original = $urls->get([
                'keyword',
                'url',
                'meta',
                'enabled',
                'password',
                'remark',
            ])->toArray()[0];

            $urls->update(array_merge($original, $data));
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating this short urls. Please try again.'));
        }

        // event(new ShortUrlsUpdated($urls));

        DB::commit();

        return $urls;
    }

    /**
     * @param  ShortUrls $urls
     * @param  $status
     * @return ShortUrls
     *
     * @throws GeneralException
     */
    public function mark(ShortUrls $urls, $status): ShortUrls
    {
        $urls->enabled = $status;

        if ($urls->save()) {
            // event(new ShortUrlsEnabledChanged($urls, $status));

            return $urls;
        }

        throw new GeneralException(__('There was a problem updating this short urls. Please try again.'));
    }

    /**
     * @param  ShortUrls $urls
     * @return ShortUrls
     *
     * @throws GeneralException
     */
    public function delete(ShortUrls $urls): ShortUrls
    {
        if ($urls->delete()) {
            // event(new ShortUrlsDeleted($urls));

            return $urls;
        }

        throw new GeneralException('There was a problem deleting this short urls. Please try again.');
    }

    /**
     * @param  array  $data
     * @return ShortUrls
     */
    protected function createShortUrls(array $data = []): ShortUrls
    {
        return $this->model::create([
            'user_id' => $data['user_id'],
            'keyword' => $data['keyword'],
            'url' => $data['url'],
            'meta' => $data['meta'] ?? [],
            'enabled' => $data['enabled'] ?? true,
            'password' => $data['password'] ?? null,
            'remark' => $data['remark'] ?? null,
        ]);
    }
}
