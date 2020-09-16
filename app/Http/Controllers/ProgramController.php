<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\Program\CreateProgramRequest;
use App\Models\Program;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Program $program)
    {
        return $this->generateCachedResponse(function () use ($filters, $program) {
            $programs = $program->filter($filters);

            return $this->paginateOrGet($programs);
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
    public function store(CreateProgramRequest $request, Program $program)
    {
        $programObject = $program->create($request->validated());

        return response($programObject, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $programObject = $program;

        return response($programObject);
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
    public function update(CreateProgramRequest $request, Program $program)
    {
        $program->update($request->validated());

        return response($program);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->status;
        $program->save();

        return response($program);
    }
}
