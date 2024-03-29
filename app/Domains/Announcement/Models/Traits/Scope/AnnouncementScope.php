<?php

namespace App\Domains\Announcement\Models\Traits\Scope;

/**
 * Trait AnnouncementScope.
 */
trait AnnouncementScope
{
    /**
     * @param    $query
     * @param    $term
     * @return mixed
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($query) use ($term) {
            $query->where('message', 'like', '%'.$term.'%');
        });
    }

    /**
     * @param    $query
     * @return mixed
     */
    public function scopeEnabled($query)
    {
        return $query->whereEnabled(true);
    }

    /**
     * @param    $query
     * @return mixed
     */
    public function scopeDismissable($query)
    {
        return $query->whereDismissable(true);
    }

    /**
     * @param    $query
     * @param    $area
     * @return mixed
     */
    public function scopeForArea($query, $area)
    {
        return $query->where(function ($query) use ($area) {
            $query->whereArea($area)
                ->orWhereNull('area');
        });
    }

    /**
     * @param    $query
     * @return mixed
     */
    public function scopeInTimeFrame($query)
    {
        return $query->where(function ($query) {
            $query->where(function ($query) {
                $query->whereNull('starts_at')
                    ->whereNull('ends_at');
            })->orWhere(function ($query) {
                $query->whereNotNull('starts_at')
                    ->whereNotNull('ends_at')
                    ->where('starts_at', '<=', now())
                    ->where('ends_at', '>=', now());
            })->orWhere(function ($query) {
                $query->whereNotNull('starts_at')
                    ->whereNull('ends_at')
                    ->where('starts_at', '<=', now());
            })->orWhere(function ($query) {
                $query->whereNull('starts_at')
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '>=', now());
            });
        });
    }
}
