<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Hub\CreateHubRequest;
use App\Models\Hub;

class HubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Hub $hub)
    {
        return $this->generateCachedResponse(function () use ($filters, $hub) {
            if (request()->user()->account_type == 2) {
                $hubs = $hub
                    ->where('id', request()->user()->coordinator->hub_id)
                    ->filter($filters)
                    ->where('status', '!=', 2);
            } else {
                $hubs = $hub->filter($filters)
                    ->where('status', '!=', 2);
            }
            $hubs->with(['school']);
            return $this->paginateOrGet($hubs);
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHubRequest $request, Hub $hub)
    {
        $hubObject = $hub->create($request->validated());

        return response($hubObject, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Hub $hub)
    {
        $hubObject = $hub->load([
            'coordinators',
            // 'transactions',
        ]);

        return response($hubObject);
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
    public function update(CreateHubRequest $request, Hub $hub)
    {
        $hub->update($request->validated());

        return response($hub);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hub $hub)
    {
        $hub->status = 2;
        $hub->save();

        return response($hub);
    }
}
