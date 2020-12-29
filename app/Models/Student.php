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
        'hub_id',
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
        'program_id',
        'coordinator_id',
        'years_in_gov',
    ];

    public function searchable()
    {
        return [
            'student_number',
            'position',
            'hub_school_name',
            'course_name',
            'user_email',
            'user_userDetail_first_name',
            'user_userDetail_last_name',
            'program_name',
            'program_course',
            'program_id',
            'course_id',
        ];
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
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

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function setStudentNumberAttribute($value)
    {
        $year = Carbon::parse($this->attributes['created_at'])->format('y');
        $paddedId = str_pad($value, 7, '0', STR_PAD_LEFT);

        $this->attributes['student_number'] = "STD-$year-$paddedId";
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }
}
