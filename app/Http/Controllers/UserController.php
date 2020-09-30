<?php

namespace App\Http\Controllers;

use App\Http\Filters\ResourceFilters;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\CmsProfile;
use App\Models\Coordinator;
use App\Models\Student;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceFilters $filters, User $user)
    {
        return $this->generateCachedResponse(function () use ($filters, $user) {
            $users = $user->with(['userDetails'])->filter($filters);

            return $this->paginateOrGet($users);
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
    public function store(CreateUserRequest $request, User $user)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $userObject = new User($request->all());
            $userObject->password = 'Password@123';
            $userObject->save();

            $userDetail = new UserDetail($request->all());
            $userDetail->user_id = $userObject->id;
            $userDetail->save();

            switch ($request->account_type) {
                // Student
                case 1:
                    $userObject->account_type = 1;
                    $student = new Student($request->all());
                    $student->user_id = $userObject->id;
                    $student->save();
                    $student->student_number = $userObject->id;
                    $student->save();
                    break;
                // Coordinator
                case 2:
                    $userObject->account_type = 2;
                    $coordinator = new Coordinator($request->all());
                    $coordinator->user_id = $userObject->id;
                    $coordinator->save();
                    break;
                // Admin
                case 3:
                    $userObject->account_type = 3;
                    $admin = new CmsProfile($request->all());
                    $admin->user_id = $userObject->id;
                    $admin->save();
                    break;
                default:
                    // code...
                    break;
            }
            $userObject->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        // Send Email

        return response($userObject, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userObject = $user->load([
            'userDetail',
            'student',
            'coordinator',
            'cmsProfile',
        ]);

        return response($userObject);
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
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $user->update($request->all());
            $user->userDetail->update($request->all());

            switch ($user->account_type) {
                case 1:
                    $user->student->update($request->all());
                break;
                case 2:
                    $user->coordinator->update($request->all());
                break;
                case 3:
                    $user->cmsProfile->update($request->all());
                break;
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return response($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->status = 0;
        $user->save();

        return response($user);
    }
}
