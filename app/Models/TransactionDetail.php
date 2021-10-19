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
        'session_cost',
    ];
    protected $appends = ['totals'];

    public function searchable()
    {
        return [
            'transaction_hub_id',
            'status',
            'type',
            'transaction_date',
            'event_status',
            'transaction_program_name',
            'transaction_student_user_userDetail_first_name',
            'transaction_student_user_userDetail_last_name',
            'transaction_hub_name',
            'transaction_date',
            'payments_official_receipt_number',
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

    public function getTotalsAttribute()
    {
        return [
            'all_official_receipt' => $this->all_official_receipt,
            'total_payment_made' => $this->total_payment_made,
        ];
    }

    public function getTotalPaidPaymentsAttribute()
    {
        return $this->event_status <= 2 ? 0 : $this->payments->sum('payment_made');
    }

    public function getTotalPaymentMadeAttribute()
    {
        return $this->payments->sum('payment_made');
    }
}
