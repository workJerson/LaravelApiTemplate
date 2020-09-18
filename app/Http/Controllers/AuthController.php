<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function testPdf()
    {
        $pdf = PDF::loadView('pdf.soa');

        return $pdf->download('invoice.pdf');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            $userCheck = (new User())->findForPassport($request->input('email') ?? $request->input('username'));

            if ($userCheck && $userCheck->login_attempts >= 3 && $userCheck->status == 0) {
                return response([
                    'error' => 'deactivated_account',
                    'message' => 'Your account is inactive.',
                ], 401);
            }

            if ($userCheck) {
                $userCheck->incrementLoginAttempts();
            }

            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = $request->user();

        if ($user->login_attempts >= 3 && $user->status == 0) {
            return response([
                'error' => 'deactivated_account',
                'message' => 'Your account is inactive.',
            ], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $user->clearLoginAttempts();

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user->load(['userDetail', 'student', 'cmsProfile', 'coordinator']),
        ]);
    }

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
