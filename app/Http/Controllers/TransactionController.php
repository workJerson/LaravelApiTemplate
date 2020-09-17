<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Models\Student;
use App\Models\Transaction;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Transaction $transaction)
    {
        return $this->generateCachedResponse(function () use ($filters, $transaction) {
            if (request()->user()->account_type == 1) {
                if (request()->user()->coordinator != null) {
                    $actor = 'coordinator';
                } else {
                    $actor = 'student';
                }
                $transactions = request()
                    ->user()
                    ->{$actor}
                    ->transactions()
                    ->filter($filters);
            } else {
                $transactions = $transaction->filter($filters);
            }

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

                foreach ($this->details as $key => $detail) {
                    $transactionObject
                    ->transactionDetails()
                    ->create([
                        'type' => $detail['type'],
                        'transaction_date' => $detail['date'].$now->year,
                        'event_status' => 1,
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTransactionRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
