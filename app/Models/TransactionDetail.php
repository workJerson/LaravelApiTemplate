<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    use Filterable;

    /**
     * event_status 1 = New
     * event_status 2 = For Payment Validation
     * event_status 3 = Paid.
     */
    protected $fillable = [
        'type',
        'transaction_date',
        'status',
        'transaction_id',
        'event_status',
    ];

    public function searchable()
    {
        return [
            'transaction_hub_id',
            'status',
            'event_status',
            'transaction_program_name',
            'transaction_student_student_number',
            'transaction_hub_name',
            'transaction_date',
        ];
    }

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
        $totalFoodFee = $this->total_food_fee;
        $totalRegistrationFee = $this->total_registration_fee;
        $totalSessionCost = $this->total_session_cost;

        $total = $totalFoodFee + $totalRegistrationFee + $totalSessionCost;

        return $total;
    }
}
