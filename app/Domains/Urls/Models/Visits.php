<?php

namespace App\Domains\Urls\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Visit.
 */
class Visit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url_id',
        'referer',
        'ip',
        'device',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
    ];
}
