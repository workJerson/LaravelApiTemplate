<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;

class DashboardController extends Controller
{
    public function __invoke(ResourceFilters $filters)
    {
        dd('dashboard');
    }

    public function getCountOfModel($model, $filters = null)
    {
        return $model->filter($filters)->count(['id']);
    }
}
