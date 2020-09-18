<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetailPayment extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'transaction_detail_id',
        'official_receipt_number',
        'payment_made',
    ];

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
}
