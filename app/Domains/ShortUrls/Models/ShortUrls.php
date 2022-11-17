<?php

namespace App\Domains\ShortUrls\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrls extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'keyword',
        'url',
        'meta',
        'enabled',
        'password',
        'remark',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     *@var array<string, string>
     */
    protected $casts = [
        'meta' => 'json',
        'enabled' => 'boolean',
    ];
}
