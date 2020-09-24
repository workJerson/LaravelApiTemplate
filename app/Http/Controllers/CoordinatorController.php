<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Models\Coordinator;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Coordinator $coordinator)
    {
        return $this->generateCachedResponse(function () use ($filters, $coordinator) {
            $coordinators = $coordinator->with(['user', 'user.userDetail', 'hub'])->filter($filters);

            return $this->paginateOrGet($coordinators);
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
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Coordinator $coordinator)
    {
        $coordinatorObject = $coordinator->load([
            'user',
            'user.userDetail',
            'hub',
        ]);

        return response($coordinatorObject);
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
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coordinator $coordinator)
    {
        $coordinator->status = 0;
        $coordinator->save();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
