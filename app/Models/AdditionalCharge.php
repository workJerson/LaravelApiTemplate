<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCharge extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'description',
        'status',
        'amount',
    ];

    public function searchable()
    {
        return [
            'description',
            'amount',
            'program_name',
        ];
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
