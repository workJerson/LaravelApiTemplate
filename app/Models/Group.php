<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description',
    ];

    public function searchable()
    {
        return [
            'name',
            'display_name',
            'description',
        ];
    }
}
