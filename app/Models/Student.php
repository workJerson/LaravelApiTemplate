<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function school()
    {
        return $this->hasOne(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
