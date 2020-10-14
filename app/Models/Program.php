<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'description',
        'total_price',
        'status',
    ];

    public function searchable()
    {
        return [
            'name',
            'status',
            'description',
            'total_price',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
