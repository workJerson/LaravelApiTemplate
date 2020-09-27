<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'user_id',
        'hub_id',
        'status',
    ];

    public function searchable()
    {
        return [
            'hub_id',
            'status',
            'user_email',
            'user_user_details_full_name',
            'student_student_number',
            'hub_name',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }
}
