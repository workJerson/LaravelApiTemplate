<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'address',
        'birth_date',
        'contact_number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
