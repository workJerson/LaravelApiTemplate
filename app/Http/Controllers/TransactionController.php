<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\GenerateSoaRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Models\Student;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    protected $details = [
        [
            'type' => 'Program Orientation',
            'date' => 'September ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'October ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'November ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'December ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'January ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'February ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'March ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'April ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'May ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'June ',
        ],
        [
            'type' => 'Training/Seminar Fee',
            'date' => 'July ',
        ],
    ];

    public function __construct()
    {
    }

    public function getMonthsFilter()
    {
        return response(['months' => $this->details]);
    }

    public function generateSoa(GenerateSoaRequest $request, Transaction $transaction)
    {
        $request->validated();
        $transactions['transactions'] = $transaction->whereIn('id', $request->transaction_ids)->with([
            'transactionDetails',
            'transactionDetails.payments',
            'hub',
            'program',
            'student',
            'student.user',
            'student.user.userDetail',
            'student.school',
            'student.course',
        ])->get();
        $pdf = PDF::loadView('pdf.soa', $transactions);
        $fileName = Carbon::now()->format('Ymdhis');

        return $pdf->download("SOA$fileName.pdf");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Transaction $transaction)
    {
        return $this->generateCachedResponse(function () use ($filters, $transaction) {
            if (request()->user()->account_type == 1 || request()->user()->account_type == 2) {
                if (request()->user()->coordinator != null) {
                    $transactions = $transaction
                        ->whereHas('hub', function ($query) {
                            return $query->where('hub_id', request()->user()->coordinator->hub_id);
                        })
                        ->filter($filters);
                } else {
                    $studentId = request()->user()->student->id;
                    $transactions = $transaction
                        ->whereHas('student', function ($query) use ($studentId) {
                            return $query->where('student_id', $studentId);
                        })
                        ->filter($filters);
                }
            } else {
                $transactions = $transaction->filter($filters);
            }
            $transactions->with(['hub', 'program', 'student.user.userDetail']);

            return $this->paginateOrGet($transactions);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request, Transaction $transaction)
    {
        $now = Carbon::now();
        $request->validated();
        try {
            DB::beginTransaction();
            if (!Student::findOrFail($request->student_id)->transactions->where('event_status', 1)->count() > 0) {
                $transactionObject = $transaction->create($request->all());

                $transactionObject->prefixed_id = $transactionObject->id;
                $transactionObject->save();
                foreach ($this->details as $key => $detail) {
                    $transactionObject
                    ->transactionDetails()
                    ->create([
                        'type' => $detail['type'],
                        'transaction_date' => $detail['date'].$now->year,
                        'event_status' => 1,
                        'session_cost' => (float) $transactionObject->program->total_price / 11,
                    ]);
                }
            } else {
                return response()->json(['message' => 'Student has an ongoing transaction'], 400);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return response($transactionObject);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transactionObject = $transaction->load([
            'program',
            'student',
            'student.school',
            'student.hub',
            'student.course',
            'student.user.userDetail',
            'transactionDetails',
            'transactionDetails.payments',
        ]);

        return response($transactionObject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        return response($transaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->status = 0;
        $transaction->save();

        return response(['message' => 'Deleted successfully']);
    }
}
