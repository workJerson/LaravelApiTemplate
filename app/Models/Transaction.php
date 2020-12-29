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
        'course_id',
        'total_actual_amount',
        'total_amount_paid',
        'student_id',
        'status',
        'event_status',
    ];
    protected $appends = [
        'total_payment_made',
        'total_remaining_balance',
        'total_admission_fee',
        'total_additional_charge',
        'additional_charge_label',
    ];

    public function searchable()
    {
        return [
            'status',
            'event_status',
            'program_name',
            'student_student_number',
            'student_user_userDetail_first_name',
            'student_user_userDetail_last_name',
            'student_hub_name',
            'prefixed_id',
        ];
    }

    public function setPrefixedIdAttribute($value)
    {
        $year = Carbon::parse($this->attributes['created_at'])->format('y');
        $paddedId = str_pad($value, 7, '0', STR_PAD_LEFT);

        $this->attributes['prefixed_id'] = "TRANS$year$paddedId";
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getTotalAdmissionFeeAttribute()
    {
        return $this->transactionDetails->where('type', 'Admission Fee')->first()->session_cost;
    }

    public function getAdditionalChargeLabelAttribute()
    {
        switch ($this->program->name) {
            case 'Baccalaureate':
                return 'Action Research';
                break;
            case 'Masters':
                return 'Policy Paper';
                break;
            case 'Doctoral':
                return 'Dissertation Fee';
                break;

            default:
                // code...
                break;
        }
    }

    public function getTotalAdditionalChargeAttribute()
    {
        switch ($this->program->name) {
            case 'Baccalaureate':
                return $this->transactionDetails->where('type', 'Action Research')->first()->session_cost;
                break;
            case 'Masters':
                return $this->transactionDetails->where('type', 'Policy Paper')->first()->session_cost;
                break;
            case 'Doctoral':
                return $this->transactionDetails->where('type', 'Dissertation Fee')->first()->session_cost;
                break;

            default:
                // code...
                break;
        }
    }

    public function getTotalPaymentMadeAttribute()
    {
        return $this->transactionDetails->sum('total_payment_made');
    }

    public function getTotalRemainingBalanceAttribute()
    {
        return $this->program->total_price - $this->transactionDetails->sum('total_payment_made');
    }
}
