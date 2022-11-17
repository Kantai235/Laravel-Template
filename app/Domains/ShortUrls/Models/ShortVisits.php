<?php

namespace App\Domains\ShortUrls\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShortVisits.
 */
class ShortVisits extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url_id',
        'ip_address',
        'user_agent',
    ];
}
