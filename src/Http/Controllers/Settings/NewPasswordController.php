<?php

namespace Ambulatory\Http\Controllers\Settings;

use Illuminate\Support\Facades\Hash;
Use Ambulatory\Http\Controllers\Controller;
Use Ambulatory\Http\Requests\NewPasswordRequest;

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

        return response()->json([
            'message' => 'Password successfully updated!',
        ]);
    }
}
