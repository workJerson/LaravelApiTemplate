<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDirectory extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'path',
        'description',
        'status',
    ];

    public function searchable()
    {
        return [
            'path',
            'description',
        ];
    }
}
