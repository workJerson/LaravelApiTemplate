<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'student_number',
        'user_id',
        'course_id',
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

    public function searchable()
    {
        return [
            'student_number',
            'position',
            'school_name',
            'course_name',
            'user_email',
            'user_userDetail_first_name',
            'user_userDetail_last_name',
        ];
    }

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

    public function setStudentNumberAttribute($value)
    {
        $year = Carbon::parse($this->attributes['created_at'])->format('y');
        $paddedId = str_pad($value, 7, '0', STR_PAD_LEFT);

        $this->attributes['student_number'] = "STD-$year-$paddedId";
    }
}
