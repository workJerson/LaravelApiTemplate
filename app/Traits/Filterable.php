<?php

namespace App\Traits;

use App\Http\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * The fields that are searchable.
     *
     * @return array
     */
    public function searchable()
    {
        return ['name'];
    }

    /**
     * The fields that are searchable on general query.
     *
     * @return array
     */
    public function searchableGeneral()
    {
        return $this->searchable();
    }

    /**
     * The field to be used for date range filters.
     *
     * @return string
     */
    public function dateField()
    {
        return 'created_at';
    }

    /**
     * Filter a result set.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
