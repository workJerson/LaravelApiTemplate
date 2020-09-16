<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'user_id',
        'school_id',
        'position',
        'ccaps',
        'letter_of_intent',
        'pds',
        'birth_certificate',
        'employment_certificate',
        'tor',
        'honorable_dismissal',
        'certificates',
        'remarks',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
