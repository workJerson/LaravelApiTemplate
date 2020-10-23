<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'description',
        'status',
        'school_id',
    ];

    public function searchable()
    {
        return [
            'name',
            'status',
            'description',
        ];
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
