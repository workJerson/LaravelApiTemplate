<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\GenerateSoaRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Models\Program;
use App\Models\Student;
use App\Models\Transaction;
use App\Traits\UsesTransactionDetailSchedules;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use UsesTransactionDetailSchedules;

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
            'program',
            'program.course',
            'student',
            'student.user',
            'student.user.userDetail',
            'student.school',
            'student.course',
            'student.hub.school',
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
                        ->whereHas('student', function ($query) {
                            return $query->where('hub_id', request()->user()->coordinator->hub_id);
                        })
                        ->filter($filters)
                        ->where('status', '!=', 2);
                } else {
                    $studentId = request()->user()->student->id;
                    $transactions = $transaction
                        ->whereHas('student', function ($query) use ($studentId) {
                            return $query->where('student_id', $studentId);
                        })
                        ->filter($filters)
                        ->where('status', '!=', 2);
                }
            } else {
                $transactions = $transaction
                    ->filter($filters)
                    ->where('status', '!=', 2);
            }
            $transactions->with(['program', 'student.user.userDetail', 'student.hub.school']);

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
        $details = [];
        $now = Carbon::now();
        $request->validated();
        try {
            DB::beginTransaction();
            if (!Student::findOrFail($request->student_id)->transactions->where('event_status', 1)->count() > 0) {
                $transactionObject = $transaction->create($request->all());

                $transactionObject->prefixed_id = $transactionObject->id;
                $transactionObject->save();
                $program = Program::findOrFail($request->program_id);

                switch ($program->name) {
                    case 'Baccalaureate':
                        $details = $this->getBaccSchedule();
                        break;
                    case 'Masters':
                        $details = $this->getMasterSchedule();
                        break;
                    case 'Doctoral':
                        $details = $this->getDoctorSchedule();
                        break;

                    default:
                        // code...
                        break;
                }
                $transactionDetails = array_map(function ($schedule) use ($now, $transactionObject) {
                    return array_merge($schedule, [
                        'created_at' => $now,
                        'updated_at' => $now,
                        'transaction_id' => $transactionObject->id,
                    ]);
                }, $details);

                $transactionObject
                    ->transactionDetails()
                    ->insert($transactionDetails);
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
            'student.hub.school',
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
        $transaction->status = 2;
        $transaction->save();

        return response(['message' => 'Deleted successfully']);
    }
}
