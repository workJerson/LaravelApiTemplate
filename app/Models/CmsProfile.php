<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsProfile extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'group_id',
        'user_id',
        'status',
    ];

    public function searchable()
    {
        return [
            'group_name',
            'user_userDetail_first_name',
            'user_userDetail_last_name',
            'status',
        ];
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
