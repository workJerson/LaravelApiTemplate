<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\CreateTransactionDetailPaymentRequest;
use App\Models\TransactionDetailPayment;

class TransactionDetailPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionDetailPaymentRequest $request, TransactionDetailPayment $transactionDetailPayment)
    {
        $data = $transactionDetailPayment->create($request->validated());

        return response($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionDetailPayment $transactionDetailPayment)
    {
        $data = $transactionDetailPayment;

        return response($data);
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
    public function update(CreateTransactionDetailPaymentRequest $request, TransactionDetailPayment $transactionDetailPayment)
    {
        $transactionDetailPayment->update($request->validated());

        return response($transactionDetailPayment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionDetailPayment $transactionDetailPayment)
    {
        $transactionDetailPayment->delete();

        return response(['message' => 'Deleted successfully']);
    }
}
