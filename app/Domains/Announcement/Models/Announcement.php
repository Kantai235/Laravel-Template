<?php

namespace App\Domains\Announcement\Models;

use App\Domains\Announcement\Models\Traits\Method\AnnouncementMethod;
use App\Domains\Announcement\Models\Traits\Scope\AnnouncementScope;
use Database\Factories\AnnouncementFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Announcement.
 */
class Announcement extends Model
{
    use AnnouncementMethod,
        AnnouncementScope,
        HasFactory,
        LogsActivity,
        SoftDeletes;

    /**
     * 列舉 area 作用區域
     * Frontend 前台
     *
     * @var string
     */
    public const AREA_FRONTEND = 'frontend';

    /**
     * 列舉 area 作用區域
     * Backend 後台
     *
     * @var string
     */
    public const AREA_BACKEND = 'backend';

    /**
     * 列舉 type 分類
     * primary
     *
     * @var string
     */
    public const TYPE_PRIMARY = 'primary';

    /**
     * 列舉 type 分類
     * secondary
     *
     * @var string
     */
    public const TYPE_SECONDARY = 'secondary';

    /**
     * 列舉 type 分類
     * success
     *
     * @var string
     */
    public const TYPE_SUCCESS = 'success';

    /**
     * 列舉 type 分類
     * danger
     *
     * @var string
     */
    public const TYPE_DANGER = 'danger';

    /**
     * 列舉 type 分類
     * warning
     *
     * @var string
     */
    public const TYPE_WARNING = 'warning';

    /**
     * 列舉 type 分類
     * info
     *
     * @var string
     */
    public const TYPE_INFO = 'info';

    /**
     * 列舉 type 分類
     * light
     *
     * @var string
     */
    public const TYPE_LIGHT = 'light';

    /**
     * 列舉 type 分類
     * dark
     *
     * @var string
     */
    public const TYPE_DARK = 'dark';

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'area',
        'type',
        'message',
        'enabled',
        'starts_at',
        'ends_at',
    ];

    /**
     * @var array<int, string>
     */
    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Logging model events.
     * https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/logging-model-events
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AnnouncementFactory::new();
    }
}
