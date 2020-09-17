<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Schema;

class ResourceFilters extends QueryFilters
{
    /**
     * Filter the selection by fields.
     *
     * @param mixed $fields
     *
     * @return Builder
     */
    public function fields($fields)
    {
        return $this->builder->addSelect(
            self::commaSeparatedStringToArray($fields)
        );
    }

    /**
     * Attach embedded relationships.
     *
     * @param mixed $fields
     *
     * @return Builder
     */
    public function with($fields)
    {
        return $this->builder->with(
            self::commaSeparatedStringToArray($fields)
        );
    }

    /**
     * Attach embedded and sorted relationships.
     *
     * @param mixed $fields
     *
     * @return Builder
     */
    public function withSorted($fields)
    {
        $builder = $this->builder;
        $fieldsArray = self::commaSeparatedStringToArray($fields);

        foreach ($fieldsArray as $field) {
            $explodedField = explode(':', $field);
            $isDescending = starts_with($explodedField[1], '-');
            $explodedField[1] = $isDescending ? substr($explodedField[1], 1) : $explodedField[1];

            $builder = $builder->with([
                $explodedField[0] => function ($query) use ($explodedField, $isDescending) {
                    $query->orderBy($explodedField[1], $isDescending ? 'desc' : 'asc');
                },
            ]);
        }

        return $builder;
    }

    /**
     * Filter by keyword for every searchable field.
     *
     * @param string $value
     *
     * @return Builder
     */
    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            foreach ($this->builder->getModel()->searchableGeneral() as $field) {
                $query = $this->filterQuery($query, $field, $value, true);
            }
        });
    }

    /**
     * Filter by field value.
     *
     * @param string $field
     * @param string $value
     *
     * @return Builder
     */
    public function searchByField($field, $value)
    {
        return $this->filterQuery($this->builder, $field, $value);
    }

    /**
     * Sort by specified fields.
     *
     * @param mixed $fields
     *
     * @return Builder
     */
    public function sort($fields)
    {
        $builder = $this->builder;

        foreach (self::commaSeparatedStringToArray($fields) as $field) {
            $isDescending = starts_with($field, '-');
            $column = $isDescending ? substr($field, 1) : $field;

            if (
                !str_contains($field, '.')
                && Schema::hasColumn($builder->getModel()->getTable(), $column)
            ) {
                $builder = $builder->orderBy($column, $isDescending ? 'desc' : 'asc');
            }
        }

        return $builder;
    }

    /**
     * Filter by date (from) specified for the model.
     *
     * @param string $value
     */
    public function dateFrom($value)
    {
        if (!$value) {
            return $this->builder;
        }
        $field = $this->builder->getModel()->dateField();

        if (!$field) {
            return $this->builder;
        }

        if (
            str_contains($field, '_')
            && !str_contains($field, $this->builder->getModel()->getTable())
            && !Schema::hasColumn($this->builder->getModel()->getTable(), $field)
        ) {
            $parsedField = splitRelationshipsAndField($field, $this->builder->getModel());
            $relationship = $parsedField['relationship'];
            $relatedField = $parsedField['fieldName'];

            return $this->builder->whereHas($relationship, function ($query) use (
                $value,
                $relatedField
            ) {
                $query->whereDate($relatedField, '>=', $value);
            });
        }

        return $this->builder->whereDate($field, '>=', $value);
    }

    /**
     * Filter by date (to) specified for the model.
     *
     * @param string $value
     */
    public function dateTo($value)
    {
        if (!$value) {
            return $this->builder;
        }
        $field = $this->builder->getModel()->dateField();

        if (!$field) {
            return $this->builder;
        }

        if (
            str_contains($field, '_')
            && !str_contains($field, $this->builder->getModel()->getTable())
            && !Schema::hasColumn($this->builder->getModel()->getTable(), $field)
        ) {
            $parsedField = splitRelationshipsAndField($field, $this->builder->getModel());
            $relationship = $parsedField['relationship'];
            $relatedField = $parsedField['fieldName'];

            return $this->builder->whereHas($relationship, function ($query) use (
                $value,
                $relatedField
            ) {
                $query->whereDate($relatedField, '<=', $value);
            });
        }

        return $this->builder->whereDate($field, '<=', $value);
    }

    /**
     * Converts comma separated query string to array format.
     *
     * @param mixed $args
     *
     * @return array
     */
    protected static function commaSeparatedStringToArray($args)
    {
        if (is_array($args)) {
            return $args;
        }

        return array_map('trim', explode(',', $args));
    }

    /**
     * Append the filter query for the given builder and parameters.
     *
     * @param Builder $builder
     * @param string  $field
     * @param string  $value
     * @param bool    $isOr
     *
     * @return Builder
     */
    protected function filterQuery($builder, $field, $value, $isOr = false)
    {
        if (!strlen($value)) {
            return $builder;
        }

        $queryToAppend = $isOr ? 'orWhere' : 'where';
        $modifier = Arr::last(explode('|', $value));
        $searchOperator = 'like';
        $searchValue = substr($value, 0, strrpos($value, '|'));

        switch ($modifier) {
            case 'left':
                $searchValue = "%$searchValue";
                break;
            case 'right':
                $searchValue = "$searchValue%";
                break;
            case 'both':
                $searchValue = "%$searchValue%";
                break;
            case 'exact':
                $searchValue = "$searchValue";
                break;
            case 'gte':
                $searchOperator = '>=';
                break;
            case 'gt':
                $searchOperator = '>';
                break;
            case 'lte':
                $searchOperator = '<=';
                break;
            case 'lt':
                $searchOperator = '<';
                break;
            case 'not':
                $searchOperator = '!=';
                break;
            case 'null':
                $searchOperator = null;
                $searchValue = null;
                break;
            case 'in':
            case 'nin':
                $searchValue = explode(',', $searchValue);
                break;
            default:
                $searchValue = "%$value%";
        }

        if (
            str_contains($field, '_')
            && !Schema::hasColumn($builder->getModel()->getTable(), $field)
        ) {
            $parsedField = splitRelationshipsAndField($field, $builder->getModel());
            $relationship = $parsedField['relationship'];
            $relatedField = $parsedField['fieldName'];

            return $builder->{$queryToAppend.'Has'}($relationship, function ($query) use (
                $value,
                $relatedField,
                $searchOperator,
                $searchValue,
                $modifier
            ) {
                if ($modifier === 'in') {
                    $query->whereIn($relatedField, $searchValue);
                } elseif ($modifier === 'nin') {
                    $query->whereNotIn($relatedField, $searchValue);
                } else {
                    $query->where($relatedField, $searchOperator, $searchValue);
                }
            });
        } elseif (!Schema::hasColumn($builder->getModel()->getTable(), $field)) {
            return $builder;
        }

        if ($modifier === 'in') {
            return $builder->{$queryToAppend.'In'}($field, $searchValue);
        }

        if ($modifier === 'nin') {
            return $builder->{$queryToAppend.'NotIn'}($field, $searchValue);
        }

        return $builder->$queryToAppend($field, $searchOperator, $searchValue);
    }
}
