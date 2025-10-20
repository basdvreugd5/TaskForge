<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BoardFilter
{
    public function apply(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query;
    }
}
