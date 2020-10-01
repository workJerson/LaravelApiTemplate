<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\CreateFileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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
    public function store(CreateFileRequest $request)
    {
        if ($request->has('private')) {
            return storePrivateFile($request->directory ?? 'uploads', $request->file('file'));
        }

        return response()->json(['path' => Storage::putFile('images', $request->file('file'), 'public')]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($path)
    {
        if (request()->has('private') && request()->user()) {
            return downloadPrivateFile($path, request()->has('download'));
        }

        if (request()->exists('download')) {
            return Storage::download($path);
        }

        return redirect(Storage::url($path));
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
