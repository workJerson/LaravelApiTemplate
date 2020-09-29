<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => [
            'required',
            'email',
            'exists:users,email',
        ]]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($status)
                    : $this->sendResetLinkFailedResponse($request, $status);
    }

    protected function sendResetLinkResponse($status)
    {
        return response([
            'message' => trans($status),
        ]);
    }

    protected function sendResetLinkFailedResponse($request, $status)
    {
        return response(trans($status), 400);
    }
}
