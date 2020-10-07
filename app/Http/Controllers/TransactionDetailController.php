<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Transaction\UpdateTransactionDetailRequest;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, TransactionDetail $transactionDetail)
    {
        return $this->generateCachedResponse(function () use ($filters, $transactionDetail) {
            if (request()->user()->account_type == 1 || request()->user()->account_type == 2) {
                if (request()->user()->coordinator != null) {
                    $transactionDetails = $transactionDetail
                        ->where('status', 1)
                        ->whereHas('transaction', function ($query) {
                            return $query->where('hub_id', request()->user()->coordinator->hub_id);
                        })
                        ->filter($filters);
                }
            } else {
                $transactionDetails = $transactionDetail
                    ->where('event_status', 2)
                    ->filter($filters);
            }

            $transactionDetails->with([
                'payments',
                'transaction',
                'transaction.program',
                'transaction.hub',
                'transaction.student.user.userDetail',
            ]);

            return $this->paginateOrGet($transactionDetails);
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
    public function store(Request $request, TransactionDetail $transactionDetail)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionDetail $transactionDetail)
    {
        $transactionObject = $transactionDetail->load([
            'payments',
            'transaction',
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
    public function update(UpdateTransactionDetailRequest $request, TransactionDetail $transactionDetail)
    {
        $transactionDetail->update($request->validated());

        return response($transactionDetail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->status = 0;
        $transactionDetail->save();

        return response(['message' => 'Deleted successfully']);
    }
}
