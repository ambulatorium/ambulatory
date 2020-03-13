<?php

namespace Ambulatory\Http\Controllers\Settings;

use Ambulatory\Http\Controllers\Controller;
use Ambulatory\Http\Requests\NewPasswordRequest;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{
    /**
     * Update user pass.
     *
     * @param  NewPasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NewPasswordRequest $request)
    {
        auth('ambulatory')->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(null, 204);
    }
}
