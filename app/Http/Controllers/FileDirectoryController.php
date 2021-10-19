<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\File\CreateFileDirectoryRequest;
use App\Models\FileDirectory;

class FileDirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, FileDirectory $fileDirectory)
    {
        return $this->generateCachedResponse(function () use ($filters, $fileDirectory) {

            $fileDirectories = $fileDirectory->filter($filters)
                ->where('status', '!=', 2);

            return $this->paginateOrGet($fileDirectories);
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
    public function store(CreateFileDirectoryRequest $request, FileDirectory $fileDirectory)
    {
        $fileDirectoryObject = $fileDirectory->create($request->validated());

        return response($fileDirectoryObject, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(FileDirectory $fileDirectory)
    {
        $fileDirectoryObject = $fileDirectory;

        return response($fileDirectoryObject);
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
    public function update(CreateFileDirectoryRequest $request, FileDirectory $fileDirectory)
    {
        $fileDirectory->update($request->validated());

        return response($fileDirectory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileDirectory $fileDirectory)
    {
        $fileDirectory->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
