<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'prefixed_id',
        'total_actual_amount',
        'total_paid_amount',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }
}
