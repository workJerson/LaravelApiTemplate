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

    public function getAllOfficialReceiptAttribute()
    {
        return $this->payments->pluck('official_receipt_number')->implode(',');
    }

    public function getTotalFoodFeeAttribute()
    {
        return $this->payments->sum('food_fee');
    }

    public function getTotalRegistrationFeeAttribute()
    {
        return $this->payments->sum('registration_fee');
    }

    public function getTotalSessionCostAttribute()
    {
        return $this->payments->sum('session_cost');
    }

    public function getTotalPaymentMadeAttribute()
    {
        return $this->payments->sum('food_fee')
            + $this->payments->sum('registration_fee')
            + $this->payments->sum('session_cost');
    }
}
