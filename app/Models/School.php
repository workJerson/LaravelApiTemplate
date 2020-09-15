<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'address',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
