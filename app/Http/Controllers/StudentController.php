<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, Student $student)
    {
        return $this->generateCachedResponse(function () use ($filters, $student) {
            $students = $student
                ->select('students.*')
                ->join('user_details', 'students.user_id', '=', 'user_details.user_id')
                ->orderBy('user_details.last_name', 'asc')
                ->where('status', '!=', 2)
                ->filter($filters);

            $user = request()->user();

            if ($user->account_type == 2) {
                $students->where('coordinator_id', $user->coordinator->id);
            }

            return $this->paginateOrGet($students->with([
                'user',
                'user.userDetail',
                'hub.school',
                'course',
                'program',
                'program.courses',
                'coordinator.user.userDetail',
                'transactions' => function ($q) {
                    $q->select('id', 'student_id')->where('event_status', 1);
                }, ]));
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
            'program',
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
