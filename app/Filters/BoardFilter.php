<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BoardFilter
{
    public function apply(Builder $query, array $filters)
    {
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }

        $type = $filters['type'] ?? null;

        if ($type === 'owned') {
            $query->where('user_id', Auth::id());
        } elseif ($type === 'shared' || $type === 'collaborator') {
            // exclude boards where the current user is the owner, then require them as a collaborator
            $query->where('user_id', '!=', Auth::id())
                ->whereHas('collaborators', function ($q) {
                    $q->where('user_id', Auth::id());
                });
        } else {
            // default: only boards user can access (owned OR shared)
            $query->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhereHas('collaborators', function ($qq) {
                        $qq->where('user_id', Auth::id());
                    });
            });
        }

        return $query;
    }
}
