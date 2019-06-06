<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Illuminate\Support\Facades\Hash;
use Reliqui\Ambulatory\Http\Controllers\Controller;
use Reliqui\Ambulatory\Http\Requests\NewPasswordRequest;

class NewPasswordController extends Controller
{
    /**
     * Update password.
     */
    public function update(NewPasswordRequest $request)
    {
        auth('ambulatory')->user()->update([
            'password' => Hash::make($request->new_password),
        ]);
    }
}
