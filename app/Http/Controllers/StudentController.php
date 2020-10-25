<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Student $student)
    {
        return $this->generateCachedResponse(function () use ($filters, $student) {
            $students = $student
            ->with(['user', 'user.userDetail', 'hub.school', 'course', ''])
            ->filter($filters)
            ->where('status', '!=', 2);

            return $this->paginateOrGet($students);
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
    public function show(Student $student)
    {
        $studentObject = $student->load([
            'user',
            'user.userDetails',
            'school',
            'transactions',
            'course',
        ]);

        return response($studentObject);
    }

    /**
     * Show the form for editing the specified resource.
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
    public function destroy(Student $student)
    {
        $student->status = 2;
        $student->user->status = 2;
        $student->save();

        return response(['message' => 'Deleted successfully']);
    }
}
