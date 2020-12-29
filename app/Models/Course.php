<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'description',
        'status',
        'program_id',
    ];

    public function searchable()
    {
        return [
            'name',
            'description',
            'status',
        ];
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
