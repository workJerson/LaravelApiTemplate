<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? $this->sendResetResponse($status)
            : $this->sendResetFailedResponse($request, $status);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|between:8,20'
                .'|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\S.*)\S*$/',
        ];
    }

    protected function sendResetResponse($response)
    {
        return response([
            'message' => trans($response),
        ]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response([
            'message' => trans($response),
        ], 400);
    }

    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'Password must have at least one uppercase letter, one lowercase letter, one number and one special character.',
        ];
    }
}
