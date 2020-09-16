<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
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
            if (request()->user()->is_web) {
                if (request()->user()->coordinator != null) {
                    $actor = 'coordinator';
                } else {
                    $actor = 'student';
                }
                $transactions = request()
                    ->user()
                    ->{$actor}()
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
    public function store(CreateTransactionRequest $request)
    {
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
