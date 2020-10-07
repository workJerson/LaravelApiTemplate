<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    use Filterable;
    /**
     *  event_status 1 = In Progress
     *  event_status 2 = Done.
     */
    protected $fillable = [
        'prefixed_id',
        'program_id',
        'total_actual_amount',
        'total_amount_paid',
        'program_id',
        'hub_id',
        'student_id',
        'status',
        'event_status',
    ];
    protected $appends = ['total_payment_made', 'total_remaining_balance'];

    public function searchable()
    {
        return [
            'hub_id',
            'status',
            'event_status',
            'program_name',
            'student_student_number',
            'hub_name',
        ];
    }

    public function setPrefixedIdAttribute($value)
    {
        $year = Carbon::parse($this->attributes['created_at'])->format('y');
        $paddedId = str_pad($value, 7, '0', STR_PAD_LEFT);

        $this->attributes['prefixed_id'] = "TRANS$year$paddedId";
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getTotalPaymentMadeAttribute()
    {
        return number_format($this->transactionDetails->sum('total_payment_made'), 2);
    }

    public function getTotalRemainingBalanceAttribute()
    {
        return number_format($this->program->total_price - $this->transactionDetails->sum('total_payment_made'), 2);
    }
}
