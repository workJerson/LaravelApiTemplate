<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetAuthenticatedUserInfo extends Controller
{
    /**
     * Get the authenticated user's information.
     *
     * @return Response
     */
    public function __invoke()
    {
        $user = request()->user();

        $user->load([
            'student',
            'coordinator',
            'coordinator.hub',
            'cmsProfile',
            'cmsProfile.group',
            'userDetail',
        ]);

        return response($user);
    }
}
