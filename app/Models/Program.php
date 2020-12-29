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
        'course',
        'total_price',
        'status',
    ];

    public function searchable()
    {
        return [
            'name',
            'status',
            'course',
            'total_price',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function additionalCharges()
    {
        return $this->hasMany(AdditionalCharge::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
