<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'type',
        'transaction_date',
        'session_cost',
        'official_receipt_number',
        'registration_fee',
        'food_fee',
        'payment_made',
        'status',
        'transaction_id',
        'event_status',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function payments()
    {
        return $this->hasMany(TransactionDetailPayment::class);
    }
}
