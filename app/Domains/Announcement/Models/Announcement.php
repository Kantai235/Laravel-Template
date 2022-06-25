<?php

namespace App\Domains\Announcement\Models;

use App\Domains\Announcement\Models\Traits\Scope\AnnouncementScope;
use Database\Factories\AnnouncementFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Announcement.
 */
class Announcement extends Model
{
    use AnnouncementScope,
        HasFactory,
        LogsActivity;

    public const AREA_FRONTEND = 'frontend';
    public const AREA_BACKEND = 'backend';

    public const TYPE_INFO = 'info';
    public const TYPE_DANGER = 'danger';
    public const TYPE_WARNING = 'warning';
    public const TYPE_SUCCESS = 'success';

    protected static $logFillable = true;
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
